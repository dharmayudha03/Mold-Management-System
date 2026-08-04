<?php

namespace App\Http\Controllers;

use App\Models\FormRepairCetakan;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FormRepairCetakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = FormRepairCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'detailUser', 'latestMjo']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nodoc', 'like', "%{$search}%")
                    ->orWhereHas('listCodeItem', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('problem', 'like', "%{$search}%");
            });
        }

        $formRepairCetakans = $query->latest()->paginate(25)->withQueryString();

        return view('form-repair-cetakans.index', compact('formRepairCetakans', 'search'));
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

    public function create()
    {
        if (auth()->user() && (auth()->user()->hasRole('User') || auth()->user()->hasRole('Pe') || auth()->user()->hasRole('pe'))) {
            return redirect()->route('form-repair-cetakans.index')->with('error', 'Role Anda tidak memiliki izin membuat Form PEJO secara langsung!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();

        $existingNumbers = FormRepairCetakan::pluck('id')->toArray();
        $nextNumber = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $nodoc = 'DOC-PEJO' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('form-repair-cetakans.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'nodoc'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'tindakan' => 'nullable|string',
            'analisa' => 'nullable|string',
            'status' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        $uploadedPaths = [];
        if ($request->hasFile('gambar')) {
            $destinationPath = public_path('uploads/pejo_repairs');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $uploadedPaths[] = 'uploads/pejo_repairs/' . $filename;
            }
        }

        $dataToInsert = [
            'detail_user_id' => $validated['detail_user_id'],
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id' => $validated['set_code_item_id'],
            'cav_code_item_id' => $validated['cav_code_item_id'],
            'nodoc' => $validated['nodoc'],
            'tanggal' => $validated['tanggal'],
            'problem' => $validated['masalah'],
            'tindakan' => $validated['tindakan'] ?? null,
            'analisa' => $validated['analisa'] ?? null,
            'status' => $validated['status'] ?? 'Pending',
            'gambar' => json_encode($uploadedPaths),
        ];

        FormRepairCetakan::create($dataToInsert);

        return redirect()->route('form-repair-cetakans.index')->with('success', 'Form Repair Cetakan (PEJO) & Gambar berhasil disimpan!');
    }

    public function edit(FormRepairCetakan $formRepairCetakan)
    {
        if (auth()->user() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('supervisor') || auth()->user()->hasRole('Svp') || auth()->user()->hasRole('spv'))) {
            return redirect()->route('form-repair-cetakans.index')->with('error', 'Role Anda tidak memiliki izin mengedit Form PEJO!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $formRepairCetakan->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $formRepairCetakan->list_code_item_id)
            ->where('set_code_item_id', $formRepairCetakan->set_code_item_id)->get();

        return view('form-repair-cetakans.edit', compact(
            'formRepairCetakan', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems'
        ));
    }

    public function update(Request $request, FormRepairCetakan $formRepairCetakan)
    {
        if (auth()->user() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('supervisor') || auth()->user()->hasRole('Svp') || auth()->user()->hasRole('spv'))) {
            return redirect()->route('form-repair-cetakans.index')->with('error', 'Role Anda tidak memiliki izin mengedit Form PEJO!');
        }
        $validated = $request->validate([
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'tindakan' => 'nullable|string',
            'analisa' => 'nullable|string',
            'status' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        $existing = json_decode($formRepairCetakan->gambar, true) ?? [];
        if (!is_array($existing)) {
            $existing = $formRepairCetakan->gambar ? [$formRepairCetakan->gambar] : [];
        }

        if ($request->hasFile('gambar')) {
            $destinationPath = public_path('uploads/pejo_repairs');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $uploadedPaths = [];
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $uploadedPaths[] = 'uploads/pejo_repairs/' . $filename;
            }
            $existing = array_merge($existing, $uploadedPaths);
        }

        $dataToUpdate = [
            'detail_user_id' => $validated['detail_user_id'],
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id' => $validated['set_code_item_id'],
            'cav_code_item_id' => $validated['cav_code_item_id'],
            'nodoc' => $validated['nodoc'],
            'tanggal' => $validated['tanggal'],
            'problem' => $validated['masalah'],
            'tindakan' => $validated['tindakan'] ?? null,
            'analisa' => $validated['analisa'] ?? null,
            'status' => $validated['status'] ?? $formRepairCetakan->status,
            'gambar' => json_encode($existing),
        ];

        $formRepairCetakan->update($dataToUpdate);

        return redirect()->route('form-repair-cetakans.index')->with('success', 'Form Repair Cetakan (PEJO) & Gambar berhasil diperbarui!');
    }

    public function destroy(FormRepairCetakan $formRepairCetakan)
    {
        if (auth()->user() && !auth()->user()->hasRole('super_admin')) {
            return redirect()->route('form-repair-cetakans.index')->with('error', 'Hanya Super Admin yang berhak menghapus data Form PEJO!');
        }

        $formRepairCetakan->delete();
        return redirect()->route('form-repair-cetakans.index')->with('success', 'Form Repair Cetakan (PEJO) berhasil dihapus!');
    }
}
