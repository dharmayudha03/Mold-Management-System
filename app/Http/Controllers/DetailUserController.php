<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class DetailUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DetailUser::with('role');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('role', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $detailUsers = $query->latest()->paginate(25)->withQueryString();

        return view('detail-users.index', compact('detailUsers', 'search'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('detail-users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
        ]);

        DetailUser::create($validated);

        return redirect()->route('detail-users.index')->with('success', 'Detail User berhasil ditambahkan!');
    }

    public function edit(DetailUser $detailUser)
    {
        $roles = Role::all();
        return view('detail-users.edit', compact('detailUser', 'roles'));
    }

    public function update(Request $request, DetailUser $detailUser)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
        ]);

        $detailUser->update($validated);

        return redirect()->route('detail-users.index')->with('success', 'Detail User berhasil diperbarui!');
    }

    public function destroy(DetailUser $detailUser)
    {
        $detailUser->delete();
        return redirect()->route('detail-users.index')->with('success', 'Detail User berhasil dihapus!');
    }

    public function getByRole(Request $request)
    {
        $roleParam = $request->get('role_id');

        if (!$roleParam) {
            return response()->json([]);
        }

        $query = DetailUser::query();

        if (is_numeric($roleParam)) {
            $query->where('role_id', (int)$roleParam);
        } else {
            $query->whereHas('role', function ($q) use ($roleParam) {
                $q->where('name', $roleParam);
            });
        }

        $users = $query->get(['id', 'name'])->unique('name')->values();
        return response()->json($users);
    }
}
