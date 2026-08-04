<?php

namespace App\Http\Controllers;

use App\Models\CodeItem;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use Illuminate\Http\Request;

class CodeItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = CodeItem::with(['listCodeItem', 'setCodeItem', 'cavCodeItem']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('listCodeItem', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('setCodeItem', function ($sub) use ($search) {
                    $sub->where('moldset', 'like', "%{$search}%");
                })
                ->orWhereHas('cavCodeItem', function ($sub) use ($search) {
                    $sub->where('moldcav', 'like', "%{$search}%");
                })
                ->orWhere('partname', 'like', "%{$search}%")
                ->orWhere('partnumber', 'like', "%{$search}%")
                ->orWhere('customer', 'like', "%{$search}%")
                ->orWhere('moldposisi', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $codeItems = $query->latest()->paginate(25)->withQueryString();

        return view('code-items.index', compact('codeItems', 'search', 'status'));
    }

    public function create()
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = collect();
        $cavCodeItems = collect();

        return view('code-items.create', compact('listCodeItems', 'setCodeItems', 'cavCodeItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'partname' => 'required|string|max:255',
            'partnumber' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'moldposisi' => 'required|string',
            'status' => 'required|string',
        ]);

        CodeItem::create($validated);

        return redirect()->route('code-items.index')->with('success', 'Code Item berhasil ditambahkan!');
    }

    public function edit(CodeItem $codeItem)
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $codeItem->list_code_item_id)->get();
        if ($setCodeItems->isEmpty()) {
            $setCodeItems = SetCodeItem::all();
        }
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $codeItem->list_code_item_id)->get();
        if ($cavCodeItems->isEmpty()) {
            $cavCodeItems = CavCodeItem::all();
        }

        return view('code-items.edit', compact('codeItem', 'listCodeItems', 'setCodeItems', 'cavCodeItems'));
    }

    public function update(Request $request, CodeItem $codeItem)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'partname' => 'required|string|max:255',
            'partnumber' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'moldposisi' => 'required|string',
            'status' => 'required|string',
        ]);

        $codeItem->update($validated);

        return redirect()->route('code-items.index')->with('success', 'Code Item berhasil diperbarui!');
    }

    public function destroy(CodeItem $codeItem)
    {
        $codeItem->delete();
        return redirect()->route('code-items.index')->with('success', 'Code Item berhasil dihapus!');
    }

    // API endpoint for dynamic dropdowns in forms
    public function getSets(Request $request)
    {
        $listIdParam = $request->get('list_code_item_id');
        if (!$listIdParam) {
            return response()->json([]);
        }

        if (is_numeric($listIdParam)) {
            $listId = (int) $listIdParam;
        } else {
            $item = ListCodeItem::where('name', $listIdParam)->first();
            $listId = $item ? $item->id : null;
        }

        if (!$listId) {
            return response()->json([]);
        }

        $sets = SetCodeItem::where('list_code_item_id', $listId)->get(['id', 'moldset'])->unique('moldset')->values();
        return response()->json($sets);
    }

    public function getCavs(Request $request)
    {
        $listIdParam = $request->get('list_code_item_id');
        $setIdParam = $request->get('set_code_item_id');

        if (!$listIdParam) {
            return response()->json([]);
        }

        if (is_numeric($listIdParam)) {
            $listId = (int) $listIdParam;
        } else {
            $item = ListCodeItem::where('name', $listIdParam)->first();
            $listId = $item ? $item->id : null;
        }

        if (!$listId) {
            return response()->json([]);
        }

        $query = CavCodeItem::where('list_code_item_id', $listId);

        if ($setIdParam) {
            if (is_numeric($setIdParam)) {
                $query->where('set_code_item_id', (int) $setIdParam);
            } else {
                $setObj = SetCodeItem::where('moldset', $setIdParam)->where('list_code_item_id', $listId)->first();
                if ($setObj) {
                    $query->where('set_code_item_id', $setObj->id);
                }
            }
        }

        $cavs = $query->get(['id', 'moldcav'])->unique('moldcav')->values();
        return response()->json($cavs);
    }
}
