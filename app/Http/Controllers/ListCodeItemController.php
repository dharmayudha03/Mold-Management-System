<?php

namespace App\Http\Controllers;

use App\Models\ListCodeItem;
use Illuminate\Http\Request;

class ListCodeItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ListCodeItem::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $listCodeItems = $query->latest()->paginate(25)->withQueryString();

        return view('list-code-items.index', compact('listCodeItems', 'search'));
    }

    public function create()
    {
        return view('list-code-items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Z0-9\-\.]+$/',
        ]);

        ListCodeItem::create($validated);

        return redirect()->route('list-code-items.index')->with('success', 'Master Code Item berhasil ditambahkan!');
    }

    public function edit(ListCodeItem $listCodeItem)
    {
        return view('list-code-items.edit', compact('listCodeItem'));
    }

    public function update(Request $request, ListCodeItem $listCodeItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Z0-9\-\.]+$/',
        ]);

        $listCodeItem->update($validated);

        return redirect()->route('list-code-items.index')->with('success', 'Master Code Item berhasil diperbarui!');
    }

    public function destroy(ListCodeItem $listCodeItem)
    {
        $listCodeItem->delete();
        return redirect()->route('list-code-items.index')->with('success', 'Master Code Item berhasil dihapus!');
    }
}
