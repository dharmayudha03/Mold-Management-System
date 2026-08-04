<?php

namespace App\Http\Controllers;

use App\Models\HistoryCetakan;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use Illuminate\Http\Request;

class HistoryCetakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $startCodeItemId = $request->input('start_code_item_id');
        $endCodeItemId = $request->input('end_code_item_id');

        $query = HistoryCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem']);

        // Filter Date Range
        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        // Filter Code Item Range (Alphabetical / Code Name Range e.g. FASI-007.0 s/d FTH-442.0)
        if ($startCodeItemId && $endCodeItemId) {
            $startItem = ListCodeItem::find($startCodeItemId);
            $endItem = ListCodeItem::find($endCodeItemId);
            if ($startItem && $endItem) {
                $firstName = min($startItem->name, $endItem->name);
                $lastName = max($startItem->name, $endItem->name);
                $query->whereHas('listCodeItem', function ($q) use ($firstName, $lastName) {
                    $q->whereBetween('name', [$firstName, $lastName]);
                });
            }
        } elseif ($startCodeItemId) {
            $startItem = ListCodeItem::find($startCodeItemId);
            if ($startItem) {
                $query->whereHas('listCodeItem', function ($q) use ($startItem) {
                    $q->where('name', '>=', $startItem->name);
                });
            }
        } elseif ($endCodeItemId) {
            $endItem = ListCodeItem::find($endCodeItemId);
            if ($endItem) {
                $query->whereHas('listCodeItem', function ($q) use ($endItem) {
                    $q->where('name', '<=', $endItem->name);
                });
            }
        }

        // Filter Search Keyword on Deskripsi
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('listCodeItem', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $historyCetakans = $query->latest()->paginate(25)->withQueryString();
        $listCodeItems = ListCodeItem::orderBy('name', 'asc')->get();

        return view('history-cetakans.index', compact(
            'historyCetakans',
            'search',
            'tanggalAwal',
            'tanggalAkhir',
            'startCodeItemId',
            'endCodeItemId',
            'listCodeItems'
        ));
    }

    public function create()
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();

        return view('history-cetakans.create', compact('listCodeItems', 'setCodeItems', 'cavCodeItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'deskripsi' => 'required|string',
        ]);

        HistoryCetakan::create($validated);

        return redirect()->route('history-cetakans.index')->with('success', 'History Cetakan berhasil ditambahkan!');
    }

    public function edit(HistoryCetakan $historyCetakan)
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $historyCetakan->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $historyCetakan->list_code_item_id)
            ->where('set_code_item_id', $historyCetakan->set_code_item_id)->get();

        return view('history-cetakans.edit', compact('historyCetakan', 'listCodeItems', 'setCodeItems', 'cavCodeItems'));
    }

    public function update(Request $request, HistoryCetakan $historyCetakan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'deskripsi' => 'required|string',
        ]);

        $historyCetakan->update($validated);

        return redirect()->route('history-cetakans.index')->with('success', 'History Cetakan berhasil diperbarui!');
    }

    public function destroy(HistoryCetakan $historyCetakan)
    {
        $historyCetakan->delete();
        return redirect()->route('history-cetakans.index')->with('success', 'History Cetakan berhasil dihapus!');
    }
}
