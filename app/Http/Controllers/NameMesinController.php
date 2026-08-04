<?php

namespace App\Http\Controllers;

use App\Models\NameMesin;
use App\Models\ListMesin;
use Illuminate\Http\Request;

class NameMesinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = NameMesin::with('listMesin');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('listMesin', function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%");
                });
        }

        $nameMesins = $query->latest()->paginate(25)->withQueryString();

        return view('name-mesins.index', compact('nameMesins', 'search'));
    }

    public function create()
    {
        $listMesins = ListMesin::all();
        return view('name-mesins.create', compact('listMesins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name' => 'required|string|max:255',
        ]);

        NameMesin::create($validated);

        return redirect()->route('name-mesins.index')->with('success', 'Master Nama Mesin berhasil ditambahkan!');
    }

    public function edit(NameMesin $nameMesin)
    {
        $listMesins = ListMesin::all();
        return view('name-mesins.edit', compact('nameMesin', 'listMesins'));
    }

    public function update(Request $request, NameMesin $nameMesin)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name' => 'required|string|max:255',
        ]);

        $nameMesin->update($validated);

        return redirect()->route('name-mesins.index')->with('success', 'Master Nama Mesin berhasil diperbarui!');
    }

    public function destroy(NameMesin $nameMesin)
    {
        $nameMesin->delete();
        return redirect()->route('name-mesins.index')->with('success', 'Master Nama Mesin berhasil dihapus!');
    }
}
