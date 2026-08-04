<?php

namespace App\Http\Controllers;

use App\Models\CavCodeItem;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use Illuminate\Http\Request;

class CavCodeItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = CavCodeItem::with(['listCodeItem', 'setCodeItem']);

        if ($search) {
            $query->where('moldcav', 'like', "%{$search}%")
                ->orWhereHas('listCodeItem', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('setCodeItem', function ($q) use ($search) {
                    $q->where('moldset', 'like', "%{$search}%");
                });
        }

        $cavCodeItems = $query->latest()->paginate(25)->withQueryString();

        return view('cav-code-items.index', compact('cavCodeItems', 'search'));
    }

    public function create()
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        return view('cav-code-items.create', compact('listCodeItems', 'setCodeItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'moldcav' => 'required|string|max:50',
        ]);

        CavCodeItem::create($validated);

        return redirect()->route('cav-code-items.index')->with('success', 'Master Cav Code Item berhasil ditambahkan!');
    }

    public function edit(CavCodeItem $cavCodeItem)
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $cavCodeItem->list_code_item_id)->get();
        return view('cav-code-items.edit', compact('cavCodeItem', 'listCodeItems', 'setCodeItems'));
    }

    public function update(Request $request, CavCodeItem $cavCodeItem)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'moldcav' => 'required|string|max:50',
        ]);

        $cavCodeItem->update($validated);

        return redirect()->route('cav-code-items.index')->with('success', 'Master Cav Code Item berhasil diperbarui!');
    }

    public function destroy(CavCodeItem $cavCodeItem)
    {
        $cavCodeItem->delete();
        return redirect()->route('cav-code-items.index')->with('success', 'Master Cav Code Item berhasil dihapus!');
    }
}
