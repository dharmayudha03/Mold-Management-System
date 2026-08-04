<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\ListMesin;
use App\Models\NameMesin;
use App\Models\ClassMesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Mesin::with(['listMesin', 'nameMesin', 'classMesin']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('listMesin', function ($sub) use ($search) {
                    $sub->where('code', 'like', "%{$search}%");
                })
                ->orWhereHas('nameMesin', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('classMesin', function ($sub) use ($search) {
                    $sub->where('class', 'like', "%{$search}%");
                })
                ->orWhere('posisi', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $mesins = $query->latest()->paginate(25)->withQueryString();

        return view('mesins.index', compact('mesins', 'search', 'status'));
    }

    public function create()
    {
        $listMesins = ListMesin::all();
        $nameMesins = NameMesin::all();
        $classMesins = ClassMesin::all();

        return view('mesins.create', compact('listMesins', 'nameMesins', 'classMesins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name_mesin_id' => 'required|exists:name_mesins,id',
            'class_mesin_id' => 'required|exists:class_mesins,id',
            'posisi' => 'required|string',
            'status' => 'required|string',
        ]);

        Mesin::create($validated);

        return redirect()->route('mesins.index')->with('success', 'Mesin berhasil ditambahkan!');
    }

    public function edit(Mesin $mesin)
    {
        $listMesins = ListMesin::all();
        $nameMesins = NameMesin::where('list_mesin_id', $mesin->list_mesin_id)->get();
        $classMesins = ClassMesin::where('list_mesin_id', $mesin->list_mesin_id)
            ->where('name_mesin_id', $mesin->name_mesin_id)->get();

        return view('mesins.edit', compact('mesin', 'listMesins', 'nameMesins', 'classMesins'));
    }

    public function update(Request $request, Mesin $mesin)
    {
        $validated = $request->validate([
            'list_mesin_id' => 'required|exists:list_mesins,id',
            'name_mesin_id' => 'required|exists:name_mesins,id',
            'class_mesin_id' => 'required|exists:class_mesins,id',
            'posisi' => 'required|string',
            'status' => 'required|string',
        ]);

        $mesin->update($validated);

        return redirect()->route('mesins.index')->with('success', 'Mesin berhasil diperbarui!');
    }

    public function destroy(Mesin $mesin)
    {
        $mesin->delete();
        return redirect()->route('mesins.index')->with('success', 'Mesin berhasil dihapus!');
    }

    // Dynamic dropdown APIs
    public function getNames(Request $request)
    {
        $listIdParam = $request->get('list_mesin_id');
        if (!$listIdParam) return response()->json([]);

        if (is_numeric($listIdParam)) {
            $listId = (int) $listIdParam;
        } else {
            $lm = ListMesin::where('code', $listIdParam)->first();
            $listId = $lm ? $lm->id : null;
        }

        if (!$listId) return response()->json([]);

        $names = NameMesin::where('list_mesin_id', $listId)->get(['id', 'name'])->unique('name')->values();
        return response()->json($names);
    }

    public function getClasses(Request $request)
    {
        $listIdParam = $request->get('list_mesin_id');
        $nameIdParam = $request->get('name_mesin_id');

        if (!$listIdParam && !$nameIdParam) return response()->json([]);

        $listId = null;
        if ($listIdParam) {
            if (is_numeric($listIdParam)) {
                $listId = (int) $listIdParam;
            } else {
                $lm = ListMesin::where('code', $listIdParam)->first();
                $listId = $lm ? $lm->id : null;
            }
        }

        $classes = collect();
        if ($listId) {
            $classes = ClassMesin::where('list_mesin_id', $listId)->get(['id', 'class']);
        }

        if ($classes->isEmpty() && $nameIdParam) {
            if (is_numeric($nameIdParam)) {
                $classes = ClassMesin::where('name_mesin_id', (int) $nameIdParam)->get(['id', 'class']);
            } else {
                $nm = NameMesin::where('name', $nameIdParam)->first();
                if ($nm) {
                    $classes = ClassMesin::where('name_mesin_id', $nm->id)->get(['id', 'class']);
                }
            }
        }

        $classes = $classes->unique('class')->values();
        return response()->json($classes);
    }
}
