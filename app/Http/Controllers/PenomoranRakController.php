<?php

namespace App\Http\Controllers;

use App\Models\PenomoranRak;
use App\Models\ListCodeItem;
use App\Models\SetCodeItem;
use App\Models\CavCodeItem;
use App\Models\ListRak;
use App\Models\ListNoRak;
use Illuminate\Http\Request;

class PenomoranRakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = PenomoranRak::with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listRak', 'listNoRak']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('rak', 'like', "%{$search}%")
                ->orWhere('norak', 'like', "%{$search}%")
                ->orWhereHas('listCodeItem', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('listRak', function ($sub) use ($search) {
                    $sub->where('rak', 'like', "%{$search}%");
                })
                ->orWhereHas('listNoRak', function ($sub) use ($search) {
                    $sub->where('norak', 'like', "%{$search}%");
                });
            });
        }

        $penomoranRaks = $query->latest()->paginate(25)->withQueryString();

        return view('penomoran-raks.index', compact('penomoranRaks', 'search'));
    }

    public function create()
    {
        if (auth()->user() && auth()->user()->hasRole('User')) {
            return redirect()->route('penomoran-raks.index')->with('error', 'Role User hanya memiliki hak akses untuk melihat dan mendownload laporan!');
        }

        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::all();
        $cavCodeItems = CavCodeItem::all();
        $listRaks = ListRak::all();
        $listNoRaks = ListNoRak::all();

        return view('penomoran-raks.create', compact('listCodeItems', 'setCodeItems', 'cavCodeItems', 'listRaks', 'listNoRaks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_rak_id' => 'required|exists:list_raks,id',
            'list_no_rak_id' => 'required|exists:list_no_raks,id',
        ]);

        $rakObj = ListRak::find($validated['list_rak_id']);
        $noRakObj = ListNoRak::find($validated['list_no_rak_id']);

        PenomoranRak::create([
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id'  => $validated['set_code_item_id'],
            'cav_code_item_id'  => $validated['cav_code_item_id'],
            'rak'               => $rakObj ? $rakObj->rak : null,
            'norak'             => $noRakObj ? $noRakObj->norak : null,
            'status'            => 'TERISI',
        ]);

        return redirect()->route('penomoran-raks.index')->with('success', 'Penomoran Rak berhasil ditambahkan!');
    }

    public function edit(PenomoranRak $penomoranRak)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('penomoran-raks.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }

        $listCodeItems = ListCodeItem::all();
        $setCodeItems = SetCodeItem::where('list_code_item_id', $penomoranRak->list_code_item_id)->get();
        $cavCodeItems = CavCodeItem::where('list_code_item_id', $penomoranRak->list_code_item_id)
            ->where('set_code_item_id', $penomoranRak->set_code_item_id)->get();
        $listRaks = ListRak::all();
        $listNoRaks = ListNoRak::all();

        return view('penomoran-raks.edit', compact('penomoranRak', 'listCodeItems', 'setCodeItems', 'cavCodeItems', 'listRaks', 'listNoRaks'));
    }

    public function update(Request $request, PenomoranRak $penomoranRak)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('penomoran-raks.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk mengedit data!');
        }
        $validated = $request->validate([
            'list_code_item_id' => 'required|exists:list_code_items,id',
            'set_code_item_id' => 'required|exists:set_code_items,id',
            'cav_code_item_id' => 'required|exists:cav_code_items,id',
            'list_rak_id' => 'required|exists:list_raks,id',
            'list_no_rak_id' => 'required|exists:list_no_raks,id',
        ]);

        $rakObj = ListRak::find($validated['list_rak_id']);
        $noRakObj = ListNoRak::find($validated['list_no_rak_id']);

        $penomoranRak->update([
            'list_code_item_id' => $validated['list_code_item_id'],
            'set_code_item_id'  => $validated['set_code_item_id'],
            'cav_code_item_id'  => $validated['cav_code_item_id'],
            'rak'               => $rakObj ? $rakObj->rak : null,
            'norak'             => $noRakObj ? $noRakObj->norak : null,
        ]);

        return redirect()->route('penomoran-raks.index')->with('success', 'Penomoran Rak berhasil diperbarui!');
    }

    public function destroy(PenomoranRak $penomoranRak)
    {
        $user = auth()->user();
        if ($user && $user->hasRole('Setup & Maintenance') && !$user->hasRole('super_admin')) {
            return redirect()->route('penomoran-raks.index')->with('error', 'Role Setup & Maintenance tidak diizinkan untuk menghapus data!');
        }

        $penomoranRak->delete();
        return redirect()->route('penomoran-raks.index')->with('success', 'Penomoran Rak berhasil dihapus!');
    }
}
