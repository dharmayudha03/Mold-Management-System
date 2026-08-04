<?php

namespace App\Http\Controllers;

use App\Models\ListNoRak;
use App\Models\ListRak;
use Illuminate\Http\Request;

class ListNoRakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ListNoRak::with('listRak');

        if ($search) {
            $query->where('norak', 'like', "%{$search}%")
                ->orWhereHas('listRak', function ($q) use ($search) {
                    $q->where('rak', 'like', "%{$search}%");
                });
        }

        $listNoRaks = $query->orderBy('norak', 'asc')->paginate(25)->withQueryString();

        return view('list-no-raks.index', compact('listNoRaks', 'search'));
    }

    public function create()
    {
        $listRaks = ListRak::orderBy('rak', 'asc')->get();
        return view('list-no-raks.create', compact('listRaks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_rak_id' => 'required|exists:list_raks,id',
            'norak' => 'required|string|max:50',
        ]);

        ListNoRak::create($validated);

        return redirect()->route('list-no-raks.index')->with('success', 'Master No. Rak berhasil ditambahkan!');
    }

    public function edit(ListNoRak $listNoRak)
    {
        $listRaks = ListRak::orderBy('rak', 'asc')->get();
        return view('list-no-raks.edit', compact('listNoRak', 'listRaks'));
    }

    public function update(Request $request, ListNoRak $listNoRak)
    {
        $validated = $request->validate([
            'list_rak_id' => 'required|exists:list_raks,id',
            'norak' => 'required|string|max:50',
        ]);

        $listNoRak->update($validated);

        return redirect()->route('list-no-raks.index')->with('success', 'Master No. Rak berhasil diperbarui!');
    }

    public function destroy(ListNoRak $listNoRak)
    {
        $listNoRak->delete();
        return redirect()->route('list-no-raks.index')->with('success', 'Master No. Rak berhasil dihapus!');
    }
}
