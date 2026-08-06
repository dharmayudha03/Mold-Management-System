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
        // Count ONLY active machines (status = Aktif)
        $totalMesin = Mesin::where('status', 'Aktif')->count();
        $totalSetup = FormSetupCetakan::count();
        $totalSandblasting = FormSandblasting::count();
        $totalRepair = FormRepairCetakan::count();
        $totalMjo = FormMjo::count();
        $totalSchedule = FormSchedule::count();
        
        $activeListMesinIds = Mesin::where('status', 'Aktif')->pluck('list_mesin_id');

        $cetakanNaikQuery = CetakanNaik::whereNotNull('list_code_item_id');
        if ($activeListMesinIds->isNotEmpty()) {
            $cetakanNaikQuery->whereIn('list_mesin_id', $activeListMesinIds);
        }

        $totalCetakanNaik = (clone $cetakanNaikQuery)->count();

        $totalUser = User::count();

        $recentHistory = HistoryCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem'])->latest()->take(10)->get();
        $recentSetup = FormSetupCetakan::with(['listCodeItem', 'setCodeItem', 'listMesin'])->latest()->take(10)->get();
        $recentSandblasting = FormSandblasting::with(['listCodeItem', 'setCodeItem', 'listMesin'])->latest()->take(10)->get();
        
        $recentCetakanNaik = $cetakanNaikQuery
            ->with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin'])
            ->latest()
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
        
        $activeListMesinIds = Mesin::where('status', 'Aktif')->pluck('list_mesin_id');

        $cetakanNaikQuery = CetakanNaik::whereNotNull('list_code_item_id');
        if ($activeListMesinIds->isNotEmpty()) {
            $cetakanNaikQuery->whereIn('list_mesin_id', $activeListMesinIds);
        }

        $totalCetakanNaik = (clone $cetakanNaikQuery)->count();
        $totalUser = User::count();

        $recentHistory = HistoryCetakan::with(['listCodeItem', 'setCodeItem', 'cavCodeItem'])->latest()->take(10)->get()->map(function($item) {
            return [
                'code_item' => $item->listCodeItem->name ?? '-',
                'mold_set' => $item->setCodeItem->moldset ?? '-',
                'deskripsi' => $item->deskripsi ?? '-',
            ];
        });

        $recentSetup = FormSetupCetakan::with(['listCodeItem', 'setCodeItem', 'listMesin'])->latest()->take(10)->get()->map(function($item) {
            return [
                'code_item' => $item->listCodeItem->name ?? '-',
                'mold_set' => $item->setCodeItem->moldset ?? '-',
                'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-',
            ];
        });

        $recentSandblasting = FormSandblasting::with(['listCodeItem', 'setCodeItem', 'listMesin'])->latest()->take(10)->get()->map(function($item) {
            return [
                'code_item' => $item->listCodeItem->name ?? '-',
                'mold_set' => $item->setCodeItem->moldset ?? '-',
                'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-',
            ];
        });

        $recentCetakanNaik = $cetakanNaikQuery
            ->with(['listCodeItem', 'setCodeItem', 'cavCodeItem', 'listMesin'])
            ->latest()
            ->take(10)
            ->get()->map(function($item) {
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
