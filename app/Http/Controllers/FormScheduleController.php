<?php

namespace App\Http\Controllers;

use App\Models\FormSchedule;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\ListMesin;
use App\Models\Kategori;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class FormScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = FormSchedule::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin', 'kategori', 'detailUser', 'formSetupCetakans', 'formSandblastings']);

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
                    });
            });
        }

        $formSchedules = $query->latest()->paginate(25)->withQueryString();

        return view('form-schedules.index', compact('formSchedules', 'search'));
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

        if ($user && ($user->hasRole('PPIC') || $user->hasRole('Ppic'))) {
            return Kategori::whereIn('name', [
                'SCHEDULE NAIK',
                'SCHEDULE TURUN',
                'SCHEDULE SANDBLASTING'
            ])->get();
        }

        return Kategori::all();
    }

    public function create()
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-schedules.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk membuat schedule!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();
        $listMesins = ListMesin::all();
        $kategoris = $this->getFilteredKategoris();

        $existingNumbers = FormSchedule::pluck('id')->toArray();
        $nextNumber = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $nodoc = 'DOC-SCH' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $occupiedMesinIds = \App\Models\CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();

        return view('form-schedules.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris', 'nodoc'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('form-schedules.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk membuat schedule!');
        }
        $validated = $request->validate([
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'status' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $validated['status'] = $request->input('status', 'Scheduled');
        $validated['waktu'] = $request->input('waktu', now()->format('H:i:s'));
        FormSchedule::create($validated);

        return redirect()->route('form-schedules.index')->with('success', 'Form Schedule berhasil ditambahkan!');
    }

    public function edit(FormSchedule $formSchedule)
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('PPIC') || $user->hasRole('Setup & Maintenance')) && !$user->hasRole('super_admin')) {
            return redirect()->route('form-schedules.index')->with('error', 'Role Anda tidak diizinkan untuk mengedit schedule!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $formSchedule->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $formSchedule->list_code_item_id)
            ->where('set_code_item_id', $formSchedule->set_code_item_id)->get();
        $listMesins = ListMesin::all();
        $kategoris = $this->getFilteredKategoris();
        $occupiedMesinIds = \App\Models\CetakanNaik::whereNotNull('list_code_item_id')->pluck('list_mesin_id')->toArray();

        return view('form-schedules.edit', compact(
            'formSchedule', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems', 'listMesins', 'occupiedMesinIds', 'kategoris'
        ));
    }

    public function update(Request $request, FormSchedule $formSchedule)
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('PPIC') || $user->hasRole('Setup & Maintenance')) && !$user->hasRole('super_admin')) {
            return redirect()->route('form-schedules.index')->with('error', 'Role Anda tidak diizinkan untuk mengedit schedule!');
        }

        $validated = $request->validate([
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'shift' => 'required|string',
            'status' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $validated['waktu'] = $request->input('waktu', $formSchedule->waktu ?? now()->format('H:i:s'));
        $formSchedule->update($validated);

        return redirect()->route('form-schedules.index')->with('success', 'Form Schedule berhasil diperbarui!');
    }

    public function destroy(FormSchedule $formSchedule)
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('PPIC') || $user->hasRole('Setup & Maintenance')) && !$user->hasRole('super_admin')) {
            return redirect()->route('form-schedules.index')->with('error', 'Role Anda tidak diizinkan untuk menghapus schedule!');
        }

        $formSchedule->delete();
        return redirect()->route('form-schedules.index')->with('success', 'Form Schedule berhasil dihapus!');
    }
}
