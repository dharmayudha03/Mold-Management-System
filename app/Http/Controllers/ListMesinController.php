<?php

namespace App\Http\Controllers;

use App\Models\ListMesin;
use Illuminate\Http\Request;

class ListMesinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ListMesin::query();

        if ($search) {
            $query->where('code', 'like', "%{$search}%");
        }

        $listMesins = $query->latest()->paginate(25)->withQueryString();

        return view('list-mesins.index', compact('listMesins', 'search'));
    }

    public function create()
    {
        return view('list-mesins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        ListMesin::create($validated);

        return redirect()->route('list-mesins.index')->with('success', 'Master List Mesin berhasil ditambahkan!');
    }

    public function edit(ListMesin $listMesin)
    {
        return view('list-mesins.edit', compact('listMesin'));
    }

    public function update(Request $request, ListMesin $listMesin)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $listMesin->update($validated);

        return redirect()->route('list-mesins.index')->with('success', 'Master List Mesin berhasil diperbarui!');
    }

    public function destroy(ListMesin $listMesin)
    {
        $listMesin->delete();
        return redirect()->route('list-mesins.index')->with('success', 'Master List Mesin berhasil dihapus!');
    }
}
