<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DetailUser;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $queryUser = User::with('roles');
        if ($search) {
            $queryUser->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }
        $users = $queryUser->latest()->paginate(15, ['*'], 'users_page')->withQueryString();

        $queryDetail = DetailUser::with('role');
        if ($search) {
            $queryDetail->where('name', 'like', "%{$search}%")
                ->orWhereHas('role', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $detailUsers = $queryDetail->latest()->paginate(15, ['*'], 'details_page')->withQueryString();

        $roles = Role::all();

        return view('users.index', compact('users', 'detailUsers', 'roles', 'search'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|array',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
