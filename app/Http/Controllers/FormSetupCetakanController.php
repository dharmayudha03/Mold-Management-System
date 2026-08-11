<?php

namespace App\Http\Controllers;

use App\Models\FormSetupCetakan;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\ListMesin;
use App\Models\Mesin;
use App\Models\CetakanNaik;
use App\Models\Kategori;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\FormSchedule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormSetupCetakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = FormSetupCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'kategori', 'detailUser']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nodoc', 'like', "%{$search}%")
                    ->orWhereHas('listCodeItem', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('listMesin', function ($sub) use ($search) {
                        $sub->where('code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $formSetupCetakans = $query->latest()->paginate(25)->withQueryString();
        $listCodeItems = ListCodeItem::orderBy('name')->get();

        return view('form-setup-cetakans.index', compact('formSetupCetakans', 'search', 'listCodeItems'));
    }



    private function getFilteredRoles()
    {
        $user = auth()->user();

        if ($user && ($user->hasRole('super_admin') || $user->email === 'admin@admin.com')) {
            return Role::all();
        }

        if ($user) {
            $userRoles = $user->getRoleNames();
            $roles = Role::whereIn('name', $userRoles)->get();
            if ($roles->isNotEmpty()) {
                return $roles;
            }
        }

        return Role::all();
    }

    private function getFilteredDetailUsers()
    {
        $user = auth()->user();

        if ($user && ($user->hasRole('super_admin') || $user->email === 'admin@admin.com')) {
            return DetailUser::all();
        }

        if ($user) {
            $userRoles = $user->getRoleNames();
            $roleIds = Role::whereIn('name', $userRoles)->pluck('id');
            if ($roleIds->isNotEmpty()) {
                return DetailUser::whereIn('role_id', $roleIds)->get();
            }
        }

        return DetailUser::all();
    }

    private function getFilteredKategoris()
    {
        $user = auth()->user();

        if ($user && ($user->hasRole('super_admin') || $user->email === 'admin@admin.com')) {
            return Kategori::all();
        }

        if ($user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance'))) {
            return Kategori::whereIn('name', [
                'SETUP CETAKAN NAIK',
                'SETUP CETAKAN TURUN'
            ])->get();
        }

        return Kategori::all();
    }

    private function getFactoryOperationalDate()
    {
        $now = \Carbon\Carbon::now();
        // Operasional pabrik 3 Shift (Shift 3 cutoff jam 08:00 Pagi)
        if ($now->hour < 8) {
            return $now->subDay()->format('Y-m-d');
        }
        return $now->format('Y-m-d');
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('User')) {
            return redirect()->route('form-setup-cetakans.index')->with('error', 'Role User hanya memiliki hak akses untuk melihat dan mendownload laporan!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = collect();
        $cavCodeItems = collect();

        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
        $listMesins = ListMesin::all();
        $kategoris = $this->getFilteredKategoris();
        $formSchedules = FormSchedule::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin'])
            ->where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', '!=', 'SELESAI');
            })
            ->latest()
            ->get();

        $selectedSchedule = null;
        if ($request->has('form_schedule_id')) {
            $selectedSchedule = FormSchedule::find($request->input('form_schedule_id'));
            if ($selectedSchedule) {
                $setCodeItems = SetCodeItem::where('list_code_item_id', $selectedSchedule->list_code_item_id)->get();
                $cavCodeItems = CavCodeItem::where('list_code_item_id', $selectedSchedule->list_code_item_id)
                    ->where('set_code_item_id', $selectedSchedule->set_code_item_id)->get();
            }
        }

        $existingNumbers = FormSetupCetakan::pluck('id')->toArray();
        $nextNumber = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $nodoc = 'DOC-SETUP' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        // Ambil shift dari request (dikirim via URL dari index form schedule)
        $prefilledShift = $request->input('shift', $selectedSchedule->shift ?? null);

        $operationalDate = $this->getFactoryOperationalDate();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        return view('form-setup-cetakans.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris', 'nodoc',
            'formSchedules', 'selectedSchedule', 'prefilledShift',
            'operationalDate', 'isReadonlyDate'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        $validated = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'detail_user_id' => 'required|array',
            'detail_user_id.*' => 'exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'rak' => 'nullable|string',
            'norak' => 'nullable|string',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'cav_ng' => 'nullable|integer',
            'guidepen' => 'required|string',
            'busing' => 'required|string',
            'baut' => 'required|string',
            'core' => 'required|string',
            'piston' => 'required|string',
            'pot' => 'required|string',
            'pl' => 'required|string',
            'form_schedule_id' => 'nullable|exists:form_schedules,id',
        ]);

        if ($isReadonlyDate) {
            $validated['tanggal'] = $this->getFactoryOperationalDate();
        }

        $detailUserIds = $validated['detail_user_id'];
        unset($validated['detail_user_id']);
        $validated['cav_ng'] = $validated['cav_ng'] ?? 0;

        $formSetup = FormSetupCetakan::create($validated);
        $formSetup->detailUser()->sync($detailUserIds);

        if (!empty($validated['form_schedule_id'])) {
            FormSchedule::where('id', $validated['form_schedule_id'])->update(['status' => 'SELESAI']);
        }

        return redirect()->route('form-setup-cetakans.index')->with('success', 'Form Setup Cetakan berhasil ditambahkan!');
    }

    public function edit(FormSetupCetakan $formSetupCetakan)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-setup-cetakans.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $formSetupCetakan->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $formSetupCetakan->list_code_item_id)
            ->where('set_code_item_id', $formSetupCetakan->set_code_item_id)->get();
        
        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
        $listMesins = ListMesin::all();

        $operationalDate = $this->getFactoryOperationalDate();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        return view('form-setup-cetakans.edit', compact(
            'formSetupCetakan', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris',
            'operationalDate', 'isReadonlyDate'
        ));
    }

    public function update(Request $request, FormSetupCetakan $formSetupCetakan)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-setup-cetakans.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }
        $validated = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'detail_user_id' => 'required|array',
            'detail_user_id.*' => 'exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'rak' => 'nullable|string',
            'norak' => 'nullable|string',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'cav_ng' => 'nullable|integer',
            'guidepen' => 'required|string',
            'busing' => 'required|string',
            'baut' => 'required|string',
            'core' => 'required|string',
            'piston' => 'required|string',
            'pot' => 'required|string',
            'pl' => 'required|string',
        ]);

        $detailUserIds = $validated['detail_user_id'];
        unset($validated['detail_user_id']);
        $validated['cav_ng'] = $validated['cav_ng'] ?? 0;

        $formSetupCetakan->update($validated);
        $formSetupCetakan->detailUser()->sync($detailUserIds);

        return redirect()->route('form-setup-cetakans.index')->with('success', 'Form Setup Cetakan berhasil diperbarui!');
    }

    public function destroy(FormSetupCetakan $formSetupCetakan)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-setup-cetakans.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk menghapus data!');
        }

        // Reset linked schedule status back so it reappears in dropdown
        if ($formSetupCetakan->form_schedule_id) {
            FormSchedule::where('id', $formSetupCetakan->form_schedule_id)->update(['status' => 'SCHEDULED']);
        }

        $formSetupCetakan->delete();
        return redirect()->route('form-setup-cetakans.index')->with('success', 'Form Setup Cetakan berhasil dihapus!');
    }

    private function getFilteredExportData(Request $request)
    {
        $query = FormSetupCetakan::with(['kategori', 'listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'detailUser']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->input('end_date'));
        }
        if ($request->filled('start_code_item_id') && $request->filled('end_code_item_id')) {
            $startId = min($request->input('start_code_item_id'), $request->input('end_code_item_id'));
            $endId = max($request->input('start_code_item_id'), $request->input('end_code_item_id'));
            $query->whereBetween('list_code_item_id', [$startId, $endId]);
        } elseif ($request->filled('start_code_item_id')) {
            $query->where('list_code_item_id', '>=', $request->input('start_code_item_id'));
        } elseif ($request->filled('end_code_item_id')) {
            $query->where('list_code_item_id', '<=', $request->input('end_code_item_id'));
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'Laporan_Form_Setup_Cetakan_' . date('Ymd_His') . '.csv';
        $items = $this->getFilteredExportData($request);

        $response = new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'Tanggal',
                'Kategori',
                'Shift',
                'Nama Karyawan',
                'Code Item',
                'Mold Set',
                'Mold Cav',
                'No Mesin',
                'Cav NG',
                'Guide Pen',
                'Busing',
                'Baut / Mur',
                'Core',
                'Piston',
                'Pot',
                'PL'
            ]);

            $formatCheck = function($val) {
                if (empty($val) || $val === '-' || strtoupper($val) === 'NG' || $val === '0') {
                    return '-';
                }
                return '√';
            };

            foreach ($items as $item) {
                fputcsv($handle, [
                    \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y'),
                    strtoupper($item->kategori->name ?? '-'),
                    $item->shift,
                    $item->detailUser->pluck('name')->implode(', ') ?: '-',
                    $item->listCodeItem->name ?? '-',
                    $item->setCodeItem->moldset ?? '-',
                    $item->cavCodeItem->moldcav ?? '-',
                    $item->listMesin->code ?? '-',
                    $item->cav_ng ?? 0,
                    $formatCheck($item->guidepen),
                    $formatCheck($item->busing),
                    $formatCheck($item->baut),
                    $formatCheck($item->core),
                    $formatCheck($item->piston),
                    $formatCheck($item->pot),
                    $formatCheck($item->pl)
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

    public function printPdf(Request $request)
    {
        $items = $this->getFilteredExportData($request);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return view('form-setup-cetakans.pdf', compact('items', 'startDate', 'endDate'));
    }
}
