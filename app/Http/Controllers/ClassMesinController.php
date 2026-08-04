<?php

namespace App\Http\Controllers;

use App\Models\ClassMesin;
use App\Models\ListMesin;
use App\Models\NameMesin;
use Illuminate\Http\Request;

class ClassMesinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ClassMesin::with(['listMesin', 'nameMesin']);

        if ($search) {
            $query->where('class', 'like', "%{$search}%")
                ->orWhereHas('listMesin', function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%");
                })
                ->orWhereHas('nameMesin', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $classMesins = $query->latest()->paginate(25)->withQueryString();

        return view('class-mesins.index', compact('classMesins', 'search'));
    }

    public function create()
    {
        $listMesins = ListMesin::all();
        $nameMesins = NameMesin::all();
        return view('class-mesins.create', compact('listMesins', 'nameMesins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name_mesin_id' => 'required|exists:name_mesins,id',
            'class' => 'required|string|max:255',
        ]);

        ClassMesin::create($validated);

        return redirect()->route('class-mesins.index')->with('success', 'Master Class Mesin berhasil ditambahkan!');
    }

    public function edit(ClassMesin $classMesin)
    {
        $listMesins = ListMesin::all();
        $nameMesins = NameMesin::where('list_mesin_id', $classMesin->list_mesin_id)->get();
        return view('class-mesins.edit', compact('classMesin', 'listMesins', 'nameMesins'));
    }

    public function update(Request $request, ClassMesin $classMesin)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name_mesin_id' => 'required|exists:name_mesins,id',
            'class' => 'required|string|max:255',
        ]);

        $classMesin->update($validated);

        return redirect()->route('class-mesins.index')->with('success', 'Master Class Mesin berhasil diperbarui!');
    }

    public function destroy(ClassMesin $classMesin)
    {
        $classMesin->delete();
        return redirect()->route('class-mesins.index')->with('success', 'Master Class Mesin berhasil dihapus!');
    }
}
