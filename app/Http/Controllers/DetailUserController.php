<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class DetailUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $query = DetailUser::with('role');

        if ($search !== '') {
            $lower = strtolower($search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$lower}%"])
                ->orWhereHas('role', function ($q) use ($lower) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$lower}%"]);
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

        $cacheKey = 'detail_users_role_' . (string)$roleParam;
        $users = \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () use ($roleParam) {
            $query = DetailUser::query();

            if (is_numeric($roleParam)) {
                $query->where('role_id', (int)$roleParam);
            } else {
                $query->whereHas('role', function ($q) use ($roleParam) {
                    $q->where('name', $roleParam);
                });
            }

            return $query->get(['id', 'name', 'role_id'])->unique('name')->values();
        });

        return response()->json($users);
    }
}
