<?php

namespace App\Http\Controllers;

use App\Models\FormSandblasting;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\ListMesin;
use App\Models\Kategori;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\FormSchedule;
use App\Models\CetakanNaik;
use App\Models\PenomoranRak;
use App\Models\ListRak;
use App\Models\ListNoRak;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormSandblastingController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = FormSandblasting::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'kategori', 'detailUser']);

        if ($search !== '') {
            $lower = strtolower($search);
            $compact = str_replace(' ', '', $lower);

            $query->where(function ($q) use ($lower, $compact) {
                $q->whereRaw('LOWER(nodoc) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas('listCodeItem', function ($sub) use ($lower, $compact) {
                        $sub->whereRaw('LOWER(name) LIKE ?', ["%{$lower}%"])
                            ->orWhereRaw("REPLACE(LOWER(name), ' ', '') LIKE ?", ["%{$compact}%"]);
                    })
                    ->orWhereHas('listMesin', function ($sub) use ($lower, $compact) {
                        $sub->whereRaw('LOWER(code) LIKE ?', ["%{$lower}%"])
                            ->orWhereRaw("REPLACE(LOWER(code), ' ', '') LIKE ?", ["%{$compact}%"]);
                    })
                    ->orWhereHas('kategori', function ($sub) use ($lower) {
                        $sub->whereRaw('LOWER(name) LIKE ?', ["%{$lower}%"]);
                    });
            });
        }

        $formSandblastings = $query->latest()->paginate(25)->withQueryString();
        $listCodeItems = ListCodeItem::orderBy('name')->get();

        return view('form-sandblastings.index', compact('formSandblastings', 'search', 'listCodeItems'));
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
                'MAINTENANCE SANDBLASTING',
                'SETUP SANDBLASTING'
            ])->get();
        }

        return Kategori::all();
    }

    private function getAvailableRackData($currentEditId = null)
    {
        $occupiedInPenomoran = PenomoranRak::whereNotNull('rak')->whereNotNull('norak')->get(['rak', 'norak']);
        $occupiedQuery = FormSandblasting::whereNotNull('rak')->whereNotNull('norak');
        if ($currentEditId) {
            $occupiedQuery->where('id', '!=', $currentEditId);
        }
        $occupiedInSandblasting = $occupiedQuery->get(['rak', 'norak']);

        $occupiedMap = [];
        foreach ($occupiedInPenomoran as $p) {
            $key = trim($p->rak) . '|' . trim($p->norak);
            $occupiedMap[$key] = true;
        }
        foreach ($occupiedInSandblasting as $s) {
            $key = trim($s->rak) . '|' . trim($s->norak);
            $occupiedMap[$key] = true;
        }

        $allRaks = ListRak::with('listNoRak')->orderBy('rak', 'asc')->get();

        $rackData = [];
        foreach ($allRaks as $r) {
            $rakName = trim($r->rak);
            $availableNoRaks = [];
            foreach ($r->listNoRak as $nr) {
                $noRakName = trim($nr->norak);
                $key = $rakName . '|' . $noRakName;
                if (!isset($occupiedMap[$key])) {
                    $availableNoRaks[] = $noRakName;
                }
            }
            if (count($availableNoRaks) > 0) {
                $rackData[$rakName] = array_values(array_unique($availableNoRaks));
            }
        }

        return $rackData;
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
            return redirect()->route('form-sandblastings.index')->with('error', 'Role User hanya memiliki hak akses untuk melihat dan mendownload laporan!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = collect();
        $cavCodeItems = collect();
        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
        // Mesin yang sedang proses (terpakai cetakan naik) TIDAK MUNCUL di pilihan dropdown
        $listMesins = ListMesin::whereNotIn('id', $occupiedMesinIds)->get();
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

        $existingNumbers = FormSandblasting::pluck('id')->toArray();
        $nextNumber = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $nodoc = 'DOC-SANDBLASTING' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
        $rackData = $this->getAvailableRackData();

        // Ambil shift dari request (dikirim via URL dari index form schedule)
        $prefilledShift = $request->input('shift', $selectedSchedule->shift ?? null);

        $operationalDate = $this->getFactoryOperationalDate();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        return view('form-sandblastings.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris', 'nodoc',
            'formSchedules', 'selectedSchedule', 'rackData', 'prefilledShift',
            'operationalDate', 'isReadonlyDate'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        $validated = $request->validate([
            'form_schedule_id' => 'nullable|exists:form_schedules,id',
            'role_id' => 'nullable|exists:roles,id',
            'detail_user_id' => 'required|array',
            'detail_user_id.*' => 'exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'nullable|exists:list_mesins,id',
            'rak' => 'nullable|string',
            'norak' => 'nullable|string',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'cav_ng' => 'nullable|integer',
            'sandblasting' => 'required|string',
            'cuci' => 'required|string',
            'autosol' => 'required|string',
            'gerinda' => 'required|string',
            'oiling' => 'required|string',
        ]);

        if ($isReadonlyDate) {
            $validated['tanggal'] = $this->getFactoryOperationalDate();
        }

        $detailUserIds = $validated['detail_user_id'];
        unset($validated['detail_user_id']);
        $validated['cav_ng'] = $validated['cav_ng'] ?? 0;

        $form = FormSandblasting::create($validated);
        $form->detailUser()->sync($detailUserIds);

        if (!empty($validated['form_schedule_id'])) {
            FormSchedule::where('id', $validated['form_schedule_id'])->update(['status' => 'SELESAI']);
        }

        if (($validated['oiling'] ?? '') === '√' && !empty($validated['rak']) && !empty($validated['norak'])) {
            PenomoranRak::updateOrCreate(
                [
                    'list_code_item_id' => $validated['list_code_item_id'],
                    'set_code_item_id'  => $validated['set_code_item_id'],
                    'cav_code_item_id'  => $validated['cav_code_item_id'],
                ],
                [
                    'rak'    => $validated['rak'],
                    'norak'  => $validated['norak'],
                    'status' => 'TERISI',
                ]
            );
        }

        return redirect()->route('form-sandblastings.index')->with('success', 'Form Sandblasting berhasil ditambahkan!');
    }

    public function edit(FormSandblasting $formSandblasting)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-sandblastings.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $formSandblasting->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $formSandblasting->list_code_item_id)
            ->where('set_code_item_id', $formSandblasting->set_code_item_id)->get();
        $kategoris = $this->getFilteredKategoris();
        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')
            ->where('list_mesin_id', '!=', $formSandblasting->list_mesin_id)
            ->pluck('list_mesin_id')->toArray();
        $listMesins = ListMesin::whereNotIn('id', $occupiedMesinIds)->get();
        $rackData = $this->getAvailableRackData($formSandblasting->id);
        $operationalDate = $this->getFactoryOperationalDate();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        return view('form-sandblastings.edit', compact(
            'formSandblasting', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris',
            'rackData', 'operationalDate', 'isReadonlyDate'
        ));
    }

    public function update(Request $request, FormSandblasting $formSandblasting)
    {
        $user = auth()->user();
        $isReadonlyDate = $user && ($user->hasRole('Setup & Maintenance') || $user->hasRole('Setup') || $user->hasRole('Maintenance')) && !$user->hasRole('super_admin');

        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-sandblastings.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }

        $validated = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'detail_user_id' => 'required|array',
            'detail_user_id.*' => 'exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'nullable|exists:list_mesins,id',
            'rak' => 'nullable|string',
            'norak' => 'nullable|string',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'cav_ng' => 'nullable|integer',
            'sandblasting' => 'required|string',
            'cuci' => 'required|string',
            'autosol' => 'required|string',
            'gerinda' => 'required|string',
            'oiling' => 'required|string',
        ]);

        if ($isReadonlyDate) {
            $validated['tanggal'] = $this->getFactoryOperationalDate();
        }

        $detailUserIds = $validated['detail_user_id'];
        unset($validated['detail_user_id']);
        $validated['cav_ng'] = $validated['cav_ng'] ?? 0;

        $formSandblasting->update($validated);
        $formSandblasting->detailUser()->sync($detailUserIds);

        if (($validated['oiling'] ?? '') === '√' && !empty($validated['rak']) && !empty($validated['norak'])) {
            PenomoranRak::updateOrCreate(
                [
                    'list_code_item_id' => $validated['list_code_item_id'],
                    'set_code_item_id'  => $validated['set_code_item_id'],
                    'cav_code_item_id'  => $validated['cav_code_item_id'],
                ],
                [
                    'rak'    => $validated['rak'],
                    'norak'  => $validated['norak'],
                    'status' => 'TERISI',
                ]
            );
        }

        return redirect()->route('form-sandblastings.index')->with('success', 'Form Sandblasting berhasil diperbarui!');
    }

    public function destroy(FormSandblasting $formSandblasting)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-sandblastings.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk menghapus data!');
        }

        // Reset linked schedule status back so it reappears in dropdown
        if ($formSandblasting->form_schedule_id) {
            FormSchedule::where('id', $formSandblasting->form_schedule_id)->update(['status' => 'SCHEDULED']);
        }

        $formSandblasting->delete();
        return redirect()->route('form-sandblastings.index')->with('success', 'Form Sandblasting berhasil dihapus!');
    }

    private function getFilteredExportData(Request $request)
    {
        $query = FormSandblasting::with(['kategori', 'listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'detailUser']);

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
        $fileName = 'Laporan_Form_Sandblasting_' . date('Ymd_His') . '.csv';
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
                'RAK',
                'No RAK',
                'Cav NG',
                'Sandblasting',
                'Cuci',
                'Autosol',
                'Gerinda',
                'Oiling'
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
                    $item->rak ?? '-',
                    $item->norak ?? '-',
                    $item->cav_ng ?? 0,
                    $formatCheck($item->sandblasting),
                    $formatCheck($item->cuci),
                    $formatCheck($item->autosol),
                    $formatCheck($item->gerinda),
                    $formatCheck($item->oiling)
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

        return view('form-sandblastings.pdf', compact('items', 'startDate', 'endDate'));
    }
}
