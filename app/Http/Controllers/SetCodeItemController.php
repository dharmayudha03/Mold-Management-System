<?php

namespace App\Http\Controllers;

use App\Models\SetCodeItem;
use App\Models\ListCodeItem;
use Illuminate\Http\Request;

class SetCodeItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = SetCodeItem::with('listCodeItem');

        if ($search) {
            $query->where('moldset', 'like', "%{$search}%")
                ->orWhereHas('listCodeItem', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $setCodeItems = $query->latest()->paginate(25)->withQueryString();

        return view('set-code-items.index', compact('setCodeItems', 'search'));
    }

    public function create()
    {
        $listCodeItems = ListCodeItem::all();
        return view('set-code-items.create', compact('listCodeItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'moldset' => 'required|string|max:50',
        ]);

        SetCodeItem::create($validated);

        return redirect()->route('set-code-items.index')->with('success', 'Master Set Code Item berhasil ditambahkan!');
    }

    public function edit(SetCodeItem $setCodeItem)
    {
        $listCodeItems = ListCodeItem::all();
        return view('set-code-items.edit', compact('setCodeItem', 'listCodeItems'));
    }

    public function update(Request $request, SetCodeItem $setCodeItem)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'moldset' => 'required|string|max:50',
        ]);

        $setCodeItem->update($validated);

        return redirect()->route('set-code-items.index')->with('success', 'Master Set Code Item berhasil diperbarui!');
    }

    public function destroy(SetCodeItem $setCodeItem)
    {
        $setCodeItem->delete();
        return redirect()->route('set-code-items.index')->with('success', 'Master Set Code Item berhasil dihapus!');
    }
}
