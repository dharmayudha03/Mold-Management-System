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

        return view('form-setup-cetakans.index', compact('formSetupCetakans', 'search'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'Form_Setup_Cetakan_' . date('Ymd_His') . '.csv';

        $items = FormSetupCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'kategori', 'detailUser'])->latest()->get();

        $response = new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'NO DOC', 'TANGGAL', 'KATEGORI', 'CODE ITEM', 'MOLD SET', 'MOLD CAVITY', 'MESIN', 'SHIFT', 'GUIDE PEN', 'BUSING', 'BAUT', 'CORE', 'PISTON', 'POT', 'PL', 'CAV NG', 'PIC KARYAWAN'
            ]);

            foreach ($items as $item) {
                $pics = $item->detailUser->pluck('name')->implode(', ');
                fputcsv($handle, [
                    $item->nodoc,
                    $item->tanggal,
                    $item->kategori->name ?? '-',
                    $item->listCodeItem->name ?? '-',
                    $item->setCodeItem->moldset ?? '-',
                    $item->cavCodeItem->moldcav ?? '-',
                    $item->listMesin->code ?? '-',
                    $item->shift,
                    $item->guidepen ?? '-',
                    $item->busing ?? '-',
                    $item->baut ?? '-',
                    $item->core ?? '-',
                    $item->piston ?? '-',
                    $item->pot ?? '-',
                    $item->pl ?? '-',
                    $item->cav_ng ?? 0,
                    $pics ?: '-'
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
        $items = FormSetupCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'kategori', 'detailUser'])->latest()->get();
        return view('form-setup-cetakans.pdf', compact('items'));
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

    public function create(Request $request)
    {
        if (auth()->user() && auth()->user()->hasRole('User')) {
            return redirect()->route('form-setup-cetakans.index')->with('error', 'Role User hanya memiliki hak akses untuk melihat dan mendownload laporan!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = collect();
        $cavCodeItems = collect();

        $activeListMesinIds = Mesin::where('status', 'Aktif')->pluck('list_mesin_id');
        $listMesins = $activeListMesinIds->isNotEmpty()
            ? ListMesin::whereIn('id', $activeListMesinIds)->get()
            : ListMesin::all();

        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
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

        return view('form-setup-cetakans.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris', 'nodoc',
            'formSchedules', 'selectedSchedule', 'prefilledShift'
        ));
    }

    public function store(Request $request)
    {
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
        
        $activeListMesinIds = Mesin::where('status', 'Aktif')->pluck('list_mesin_id');
        $listMesins = $activeListMesinIds->isNotEmpty()
            ? ListMesin::whereIn('id', $activeListMesinIds)->get()
            : ListMesin::all();

        $occupiedMesinIds = CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();
        $kategoris = $this->getFilteredKategoris();

        return view('form-setup-cetakans.edit', compact(
            'formSetupCetakan', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris'
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
}
