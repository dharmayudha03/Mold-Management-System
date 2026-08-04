<?php

namespace App\Http\Controllers;

use App\Models\ListRak;
use App\Models\ListNoRak;
use Illuminate\Http\Request;

class ListRakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = ListNoRak::with('listRak')
            ->join('list_raks', 'list_no_raks.list_rak_id', '=', 'list_raks.id')
            ->select('list_no_raks.*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('list_no_raks.norak', 'like', "%{$search}%")
                    ->orWhere('list_raks.rak', 'like', "%{$search}%");
            });
        }

        $listNoRaks = $query->orderBy('list_raks.rak', 'asc')
            ->orderBy('list_no_raks.norak', 'asc')
            ->paginate(25)
            ->withQueryString();

        return view('list-raks.index', compact('listNoRaks', 'search'));
    }

    public function create()
    {
        $existingRaks = ListRak::orderBy('rak', 'asc')->pluck('rak')->unique();
        return view('list-raks.create', compact('existingRaks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rak' => 'required|string|max:50',
            'norak' => 'required|string|max:50',
        ]);

        $rakName = strtoupper(trim($validated['rak']));
        $rak = ListRak::firstOrCreate(['rak' => $rakName]);

        $norakInput = trim($validated['norak']);

        // Support range e.g. 01-30 or 1-30
        if (preg_match('/^(\d+)\s*-\s*(\d+)$/', $norakInput, $matches)) {
            $start = (int)$matches[1];
            $end   = (int)$matches[2];
            for ($i = $start; $i <= $end; $i++) {
                $noRakStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                ListNoRak::firstOrCreate([
                    'list_rak_id' => $rak->id,
                    'norak' => $noRakStr
                ]);
            }
        } else {
            ListNoRak::firstOrCreate([
                'list_rak_id' => $rak->id,
                'norak' => $norakInput
            ]);
        }

        return redirect()->route('list-raks.index')->with('success', 'Master Data Rak & No. Rak berhasil disimpan!');
    }

    public function edit($id)
    {
        $item = ListNoRak::with('listRak')->findOrFail($id);
        $existingRaks = ListRak::orderBy('rak', 'asc')->pluck('rak')->unique();
        return view('list-raks.edit', compact('item', 'existingRaks'));
    }

    public function update(Request $request, $id)
    {
        $item = ListNoRak::findOrFail($id);

        $validated = $request->validate([
            'rak' => 'required|string|max:50',
            'norak' => 'required|string|max:50',
        ]);

        $rakName = strtoupper(trim($validated['rak']));
        $rak = ListRak::firstOrCreate(['rak' => $rakName]);

        $item->update([
            'list_rak_id' => $rak->id,
            'norak' => trim($validated['norak']),
        ]);

        return redirect()->route('list-raks.index')->with('success', 'Master No. Rak berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = ListNoRak::findOrFail($id);
        $item->delete();

        return redirect()->route('list-raks.index')->with('success', 'Master No. Rak berhasil dihapus!');
    }
}
