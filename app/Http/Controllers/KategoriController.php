<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kategori::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $kategoris = $query->latest()->paginate(25)->withQueryString();

        return view('kategoris.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
