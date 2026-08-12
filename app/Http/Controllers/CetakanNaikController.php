<?php

namespace App\Http\Controllers;

use App\Models\CetakanNaik;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\ListMesin;
use App\Models\Mesin;
use Illuminate\Http\Request;

class CetakanNaikController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = CetakanNaik::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('listCodeItem', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('listMesin', function ($sub) use ($search) {
                    $sub->where('code', 'like', "%{$search}%");
                })
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $cetakanNaiks = $query->latest()->paginate(25)->withQueryString();

        return view('cetakan-naiks.index', compact('cetakanNaiks', 'search'));
    }

    public function create()
    {
        if (auth()->user() && auth()->user()->hasRole('User')) {
            return redirect()->route('cetakan-naiks.index')->with('error', 'Role User hanya memiliki hak akses untuk melihat dan mendownload laporan!');
        }

        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();

        // Get complete list of all machines so no machine code is missing in dropdown
        $listMesins = ListMesin::orderBy('id')->get();

        return view('cetakan-naiks.create', compact('listCodeItems', 'setCodeItems', 'cavCodeItems', 'listMesins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggalnaik' => 'required|date',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'keterangan' => 'required|string',
        ]);

        CetakanNaik::create($validated);

        return redirect()->route('cetakan-naiks.index')->with('success', 'Cetakan Naik berhasil ditambahkan!');
    }

    public function edit(CetakanNaik $cetakanNaik)
    {
        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $cetakanNaik->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $cetakanNaik->list_code_item_id)
            ->where('set_code_item_id', $cetakanNaik->set_code_item_id)->get();

        // Get complete list of all machines so no machine code is missing in dropdown
        $listMesins = ListMesin::orderBy('id')->get();

        return view('cetakan-naiks.edit', compact('cetakanNaik', 'listCodeItems', 'setCodeItems', 'cavCodeItems', 'listMesins'));
    }

    public function update(Request $request, CetakanNaik $cetakanNaik)
    {
        $validated = $request->validate([
            'tanggalnaik' => 'required|date',
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'keterangan' => 'required|string',
        ]);

        $cetakanNaik->update($validated);

        return redirect()->route('cetakan-naiks.index')->with('success', 'Cetakan Naik berhasil diperbarui!');
    }

    public function destroy(CetakanNaik $cetakanNaik)
    {
        if (auth()->user() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('leader'))) {
            return redirect()->route('cetakan-naiks.index')->with('error', 'Role Leader tidak memiliki hak akses untuk menghapus data!');
        }

        $cetakanNaik->delete();
        return redirect()->route('cetakan-naiks.index')->with('success', 'Cetakan Naik berhasil dihapus!');
    }
}
