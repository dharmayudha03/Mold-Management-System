<?php

namespace App\Http\Controllers;

use App\Models\FormMjo;
use App\Models\FormRepairCetakan;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FormMjoController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = FormMjo::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'detailUser', 'formRepairCetakan']);

        if ($search !== '') {
            $lower = strtolower($search);
            $compact = str_replace(' ', '', $lower);

            $query->where(function ($q) use ($lower, $compact) {
                $q->whereRaw('LOWER(nodoc) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas('listCodeItem', function ($sub) use ($lower, $compact) {
                        $sub->whereRaw('LOWER(name) LIKE ?', ["%{$lower}%"])
                            ->orWhereRaw("REPLACE(LOWER(name), ' ', '') LIKE ?", ["%{$compact}%"]);
                    })
                    ->orWhereHas('formRepairCetakan', function ($sub) use ($lower) {
                        $sub->whereRaw('LOWER(nodoc) LIKE ?', ["%{$lower}%"]);
                    })
                    ->orWhereRaw('LOWER(penanganan) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(tindakan_moldshop) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(status) LIKE ?', ["%{$lower}%"]);
            });
        }

        $formMjos = $query->latest()->paginate(25)->withQueryString();

        return view('form-mjos.index', compact('formMjos', 'search'));
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

    public function create(Request $request)
    {
        if (auth()->user() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('User') || auth()->user()->hasRole('Msd') || auth()->user()->hasRole('msd') || auth()->user()->hasRole('MSD'))) {
            return redirect()->route('form-mjos.index')->with('error', 'Role Anda hanya memiliki hak akses untuk mengedit/melihat Form MJO!');
        }

        $roles = $this->getFilteredRoles();
        $detailUsers = $this->getFilteredDetailUsers();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();
        $selectedPejoId = $request->input('pejo_id');
        $usedPejoIds = FormMjo::whereNotNull('form_repair_cetakan_id')->pluck('form_repair_cetakan_id')->toArray();
        if ($selectedPejoId) {
            $usedPejoIds = array_diff($usedPejoIds, [(int)$selectedPejoId]);
        }

        $pejos = FormRepairCetakan::whereNotIn('id', $usedPejoIds)
            ->with(['listCodeItem', 'setCodeItem', 'cavCodeItem'])
            ->latest()
            ->get();

        $selectedPejo = $selectedPejoId ? FormRepairCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem'])->find($selectedPejoId) : null;

        $existingNumbers = FormMjo::pluck('id')->toArray();
        $nextNumber = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $nodoc = 'DOC-MJO' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('form-mjos.create', compact(
            'roles', 'detailUsers', 'listCodeItems', 'setCodeItems',
            'cavCodeItems', 'pejos', 'selectedPejoId', 'selectedPejo', 'nodoc'
        ));
    }

    public function store(Request $request)
    {
        if (auth()->user() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('User') || auth()->user()->hasRole('Msd') || auth()->user()->hasRole('msd') || auth()->user()->hasRole('MSD'))) {
            return redirect()->route('form-mjos.index')->with('error', 'Role Anda hanya memiliki hak akses untuk mengedit/melihat Form MJO!');
        }
        $validated = $request->validate([
            'form_repair_cetakan_id' => 'nullable|exists:form_repair_cetakans,id',
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'tindakan' => 'nullable|string',
            'status' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        $uploadedPaths = [];
        if ($request->hasFile('gambar')) {
            $destinationPath = public_path('uploads/mjos');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $uploadedPaths[] = 'uploads/mjos/' . $filename;
            }
        }

        $dataToInsert = [
            'form_repair_cetakan_id' => $validated['form_repair_cetakan_id'] ?? null,
            'detail_user_id' => $validated['detail_user_id'],
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id' => $validated['set_code_item_id'],
            'cav_code_item_id' => $validated['cav_code_item_id'],
            'nodoc' => $validated['nodoc'],
            'tanggal' => $validated['tanggal'],
            'penanganan' => $validated['masalah'],
            'tindakan' => $validated['tindakan'] ?? null,
            'status' => $validated['status'] ?? 'Pending',
            'gambar' => json_encode($uploadedPaths),
        ];

        FormMjo::create($dataToInsert);

        return redirect()->route('form-mjos.index')->with('success', 'Form MJO & Gambar berhasil disimpan!');
    }

    public function edit(FormMjo $formMjo)
    {
        $user = auth()->user();
        $isMsd = $user && ($user->hasRole('Msd') || $user->hasRole('msd') || $user->hasRole('MSD')) && !$user->hasRole('super_admin');

        if ($isMsd && $formMjo->status == 'Selesai') {
            return redirect()->route('form-mjos.index')->with('error', 'Form MJO ini sudah berstatus Selesai dan tidak dapat diubah kembali!');
        }

        if ($user && !$user->hasRole('super_admin') && !$user->hasRole('Msd') && !$user->hasRole('msd') && !$user->hasRole('MSD')) {
            return redirect()->route('form-mjos.index')->with('error', 'Role PE hanya memiliki hak akses input Form MJO (tidak dapat mengedit)!');
        }

        $roles = Role::all();
        $detailUsers = DetailUser::all();
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $formMjo->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $formMjo->list_code_item_id)
            ->where('set_code_item_id', $formMjo->set_code_item_id)->get();

        $usedPejoIds = FormMjo::whereNotNull('form_repair_cetakan_id')
            ->where('id', '!=', $formMjo->id)
            ->pluck('form_repair_cetakan_id')
            ->toArray();

        $pejos = FormRepairCetakan::whereNotIn('id', $usedPejoIds)
            ->with(['listCodeItem', 'setCodeItem', 'cavCodeItem'])
            ->latest()
            ->get();

        return view('form-mjos.edit', compact(
            'formMjo', 'roles', 'detailUsers', 'listCodeItems',
            'setCodeItems', 'cavCodeItems', 'pejos'
        ));
    }

    public function update(Request $request, FormMjo $formMjo)
    {
        $user = auth()->user();
        $isMsd = $user && ($user->hasRole('Msd') || $user->hasRole('msd') || $user->hasRole('MSD')) && !$user->hasRole('super_admin');

        if ($isMsd) {
            if ($formMjo->status == 'Selesai') {
                return redirect()->route('form-mjos.index')->with('error', 'Form MJO ini sudah berstatus Selesai dan tidak dapat diubah kembali!');
            }
            $validated = $request->validate([
                'status' => 'nullable|string',
                'tglselesai' => 'nullable|date',
                'tindakan_moldshop' => 'nullable|string',
                'gambar_selesai.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
            ]);

            // Proof Photos Moldshop
            $existingSelesai = json_decode($formMjo->gambar_selesai, true) ?? [];
            if (!is_array($existingSelesai)) {
                $existingSelesai = $formMjo->gambar_selesai ? [$formMjo->gambar_selesai] : [];
            }
            if ($request->hasFile('gambar_selesai')) {
                $destinationPathSelesai = public_path('uploads/mjo_selesai');
                if (!File::exists($destinationPathSelesai)) {
                    File::makeDirectory($destinationPathSelesai, 0755, true, true);
                }
                $uploadedPathsSelesai = [];
                foreach ($request->file('gambar_selesai') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPathSelesai, $filename);
                    $uploadedPathsSelesai[] = 'uploads/mjo_selesai/' . $filename;
                }
                $existingSelesai = array_merge($existingSelesai, $uploadedPathsSelesai);
            }

            $dataToUpdate = [
                'status' => $validated['status'] ?? $formMjo->status,
                'tglselesai' => $validated['tglselesai'] ?? $formMjo->tglselesai,
                'tindakan_moldshop' => $validated['tindakan_moldshop'] ?? $formMjo->tindakan_moldshop,
                'gambar_selesai' => json_encode($existingSelesai),
            ];

            $formMjo->update($dataToUpdate);

            // Auto-update PEJO status if Mold Shop marks MJO as Selesai
            if ($formMjo->form_repair_cetakan_id && isset($validated['status']) && $validated['status'] == 'Selesai') {
                $pejo = FormRepairCetakan::find($formMjo->form_repair_cetakan_id);
                if ($pejo) {
                    $pejo->update(['status' => 'Selesai']);
                }
            }

            return redirect()->route('form-mjos.index')->with('success', 'Data Hasil Perbaikan Mold Shop MJO berhasil diperbarui!');
        }

        if ($user && !$user->hasRole('super_admin') && !$user->hasRole('Pe') && !$user->hasRole('pe') && !$user->hasRole('PE')) {
            return redirect()->route('form-mjos.index')->with('error', 'Role Anda tidak diizinkan mengedit Form MJO!');
        }

        $validated = $request->validate([
            'form_repair_cetakan_id' => 'nullable|exists:form_repair_cetakans,id',
            'detail_user_id' => 'required|exists:detail_users,id',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'nodoc' => 'required|string',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'tindakan' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',

            // Mold Shop fields
            'status' => 'nullable|string',
            'tglselesai' => 'nullable|date',
            'tindakan_moldshop' => 'nullable|string',
            'gambar_selesai.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        // PE Upload Photos
        $existing = json_decode($formMjo->gambar, true) ?? [];
        if (!is_array($existing)) {
            $existing = $formMjo->gambar ? [$formMjo->gambar] : [];
        }
        if ($request->hasFile('gambar')) {
            $destinationPath = public_path('uploads/mjos');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $uploadedPaths = [];
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $uploadedPaths[] = 'uploads/mjos/' . $filename;
            }
            $existing = array_merge($existing, $uploadedPaths);
        }

        // Mold Shop Proof Photos
        $existingSelesai = json_decode($formMjo->gambar_selesai, true) ?? [];
        if (!is_array($existingSelesai)) {
            $existingSelesai = $formMjo->gambar_selesai ? [$formMjo->gambar_selesai] : [];
        }
        if ($request->hasFile('gambar_selesai')) {
            $destinationPathSelesai = public_path('uploads/mjo_selesai');
            if (!File::exists($destinationPathSelesai)) {
                File::makeDirectory($destinationPathSelesai, 0755, true, true);
            }
            $uploadedPathsSelesai = [];
            foreach ($request->file('gambar_selesai') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPathSelesai, $filename);
                $uploadedPathsSelesai[] = 'uploads/mjo_selesai/' . $filename;
            }
            $existingSelesai = array_merge($existingSelesai, $uploadedPathsSelesai);
        }

        $dataToUpdate = [
            'form_repair_cetakan_id' => $validated['form_repair_cetakan_id'] ?? $formMjo->form_repair_cetakan_id,
            'detail_user_id' => $validated['detail_user_id'],
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id' => $validated['set_code_item_id'],
            'cav_code_item_id' => $validated['cav_code_item_id'],
            'nodoc' => $validated['nodoc'],
            'tanggal' => $validated['tanggal'],
            'penanganan' => $validated['masalah'],
            'tindakan' => $validated['tindakan'] ?? $formMjo->tindakan,
            'gambar' => json_encode($existing),

            'status' => $validated['status'] ?? $formMjo->status,
            'tglselesai' => $validated['tglselesai'] ?? $formMjo->tglselesai,
            'tindakan_moldshop' => $validated['tindakan_moldshop'] ?? $formMjo->tindakan_moldshop,
            'gambar_selesai' => json_encode($existingSelesai),
        ];

        $formMjo->update($dataToUpdate);

        // Auto-update PEJO status if Mold Shop marks MJO as Selesai
        if ($formMjo->form_repair_cetakan_id && isset($validated['status']) && $validated['status'] == 'Selesai') {
            $pejo = FormRepairCetakan::find($formMjo->form_repair_cetakan_id);
            if ($pejo) {
                $pejo->update(['status' => 'Selesai']);
            }
        }

        return redirect()->route('form-mjos.index')->with('success', 'Data Form MJO berhasil diperbarui!');
    }

    public function destroy(FormMjo $formMjo)
    {
        if (auth()->user() && !auth()->user()->hasRole('super_admin')) {
            return redirect()->route('form-mjos.index')->with('error', 'Hanya Super Admin yang berhak menghapus data Form MJO!');
        }

        $formMjo->delete();
        return redirect()->route('form-mjos.index')->with('success', 'Form MJO berhasil dihapus!');
    }
}
