<?php

namespace App\Http\Controllers;

use App\Models\CodeItem;
use App\Models\Mesin;
use App\Models\FormSetupCetakan;
use App\Models\FormSandblasting;
use App\Models\FormRepairCetakan;
use App\Models\FormMjo;
use App\Models\FormSchedule;
use App\Models\CetakanNaik;
use App\Models\HistoryCetakan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCodeItem = CodeItem::count();
        $totalMesin = Mesin::where('status', 'Aktif')->count();
        $totalSetup = FormSetupCetakan::count();
        $totalSandblasting = FormSandblasting::count();
        $totalRepair = FormRepairCetakan::count();
        $totalMjo = FormMjo::count();
        $totalSchedule = FormSchedule::count();
        $totalUser = User::count();

        // Optimized subquery execution (1 SQL query instead of pluck array overhead)
        $activeMesinSubquery = Mesin::where('status', 'Aktif')->select('list_mesin_id');

        $cetakanNaikQuery = CetakanNaik::whereNotNull('list_code_item_id')
            ->whereIn('list_mesin_id', $activeMesinSubquery);

        $totalCetakanNaik = (clone $cetakanNaikQuery)->count();

        // Optimized eager loading selects
        $recentHistory = HistoryCetakan::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'cavCodeItem:id,moldcav'])
            ->latest('id')
            ->take(10)
            ->get();

        $recentSetup = FormSetupCetakan::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get();

        $recentSandblasting = FormSandblasting::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get();
        
        $recentCetakanNaik = $cetakanNaikQuery
            ->with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'cavCodeItem:id,moldcav', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalCodeItem',
            'totalMesin',
            'totalSetup',
            'totalSandblasting',
            'totalRepair',
            'totalMjo',
            'totalSchedule',
            'totalCetakanNaik',
            'totalUser',
            'recentHistory',
            'recentSetup',
            'recentSandblasting',
            'recentCetakanNaik'
        ));
    }

    public function apiData()
    {
        $totalCodeItem = CodeItem::count();
        $totalMesin = Mesin::where('status', 'Aktif')->count();
        $totalSetup = FormSetupCetakan::count();
        $totalSandblasting = FormSandblasting::count();
        $totalRepair = FormRepairCetakan::count();
        $totalMjo = FormMjo::count();
        $totalSchedule = FormSchedule::count();
        $totalUser = User::count();

        $activeMesinSubquery = Mesin::where('status', 'Aktif')->select('list_mesin_id');

        $cetakanNaikQuery = CetakanNaik::whereNotNull('list_code_item_id')
            ->whereIn('list_mesin_id', $activeMesinSubquery);

        $totalCetakanNaik = (clone $cetakanNaikQuery)->count();

        $recentHistory = HistoryCetakan::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'cavCodeItem:id,moldcav'])
            ->latest('id')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'code_item' => $item->listCodeItem->name ?? '-',
                    'mold_set' => $item->setCodeItem->moldset ?? '-',
                    'deskripsi' => $item->deskripsi ?? '-',
                ];
            });

        $recentSetup = FormSetupCetakan::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'code_item' => $item->listCodeItem->name ?? '-',
                    'mold_set' => $item->setCodeItem->moldset ?? '-',
                    'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-',
                ];
            });

        $recentSandblasting = FormSandblasting::with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'code_item' => $item->listCodeItem->name ?? '-',
                    'mold_set' => $item->setCodeItem->moldset ?? '-',
                    'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-',
                ];
            });

        $recentCetakanNaik = $cetakanNaikQuery
            ->with(['listCodeItem:id,name', 'setCodeItem:id,moldset', 'cavCodeItem:id,moldcav', 'listMesin:id,code'])
            ->latest('id')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'mesin' => $item->listMesin->code ?? '-',
                    'code_item' => $item->listCodeItem->name ?? '-',
                    'mold_set' => $item->setCodeItem->moldset ?? '-',
                    'mold_cavity' => $item->cavCodeItem->moldcav ?? '-',
                    'tanggal_naik' => $item->tanggalnaik ? \Carbon\Carbon::parse($item->tanggalnaik)->format('d/m/Y') : '-',
                ];
            });

        return response()->json([
            'totalCodeItem' => number_format($totalCodeItem),
            'totalMesin' => number_format($totalMesin),
            'totalSetup' => number_format($totalSetup),
            'totalSandblasting' => number_format($totalSandblasting),
            'totalRepair' => number_format($totalRepair),
            'totalMjo' => number_format($totalMjo),
            'totalSchedule' => number_format($totalSchedule),
            'totalCetakanNaik' => number_format($totalCetakanNaik),
            'totalUser' => number_format($totalUser),
            'recentHistory' => $recentHistory,
            'recentSetup' => $recentSetup,
            'recentSandblasting' => $recentSandblasting,
            'recentCetakanNaik' => $recentCetakanNaik,
        ]);
    }
}
