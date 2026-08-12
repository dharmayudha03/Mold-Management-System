<?php

namespace App\Http\Controllers;

use App\Models\CodeItem;
use App\Models\ListCodeItem;
use App\Models\Mesin;
use App\Models\FormSetupCetakan;
use App\Models\FormSandblasting;
use App\Models\FormRepairCetakan;
use App\Models\FormMjo;
use App\Models\FormSchedule;
use App\Models\CetakanNaik;
use App\Models\HistoryCetakan;
use App\Models\PenomoranRak;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getDashboardReportMolds()
    {
        $codeItems = ListCodeItem::orderBy('updated_at', 'desc')->take(8)->get();

        return $codeItems->map(function ($item) {
            // Masak (Cetakan Naik)
            $totalMasak = CetakanNaik::where('list_code_item_id', $item->id)->count();
            $lastMasak = CetakanNaik::where('list_code_item_id', $item->id)->latest('tanggalnaik')->first();
            $tglMasak = $lastMasak && $lastMasak->tanggalnaik ? \Carbon\Carbon::parse($lastMasak->tanggalnaik)->format('d/m/Y') : '-';

            // Sandblasting
            $totalSandblasting = FormSandblasting::where('list_code_item_id', $item->id)->count();

            // Repair (PEJO & MJO)
            $totalPejo = FormRepairCetakan::where('list_code_item_id', $item->id)->count();
            $totalMjo = FormMjo::where('list_code_item_id', $item->id)->count();
            $totalRepair = $totalPejo + $totalMjo;

            $lastPejo = FormRepairCetakan::where('list_code_item_id', $item->id)->latest('tanggal')->first();
            $lastMjo = FormMjo::where('list_code_item_id', $item->id)->latest('tanggal')->first();

            $pejoTime = ($lastPejo && $lastPejo->tanggal) ? strtotime($lastPejo->tanggal) : 0;
            $mjoTime = ($lastMjo && $lastMjo->tanggal) ? strtotime($lastMjo->tanggal) : 0;

            if ($pejoTime || $mjoTime) {
                $tglRepair = ($pejoTime >= $mjoTime)
                    ? \Carbon\Carbon::parse($lastPejo->tanggal)->format('d/m/Y')
                    : \Carbon\Carbon::parse($lastMjo->tanggal)->format('d/m/Y');
            } else {
                $tglRepair = '-';
            }

            // Location & Active Status Check
            $activeNaik = CetakanNaik::where('list_code_item_id', $item->id)
                ->where('keterangan', '!=', 'Tidak Produksi')
                ->where('keterangan', '!=', 'BELUM MASAK')
                ->with('listMesin')
                ->latest('id')
                ->first();

            $rak = PenomoranRak::where('list_code_item_id', $item->id)->with(['listRak', 'listNoRak'])->first();

            if ($activeNaik) {
                $status = 'Sedang Masak';
                $lokasi = 'Mesin ' . ($activeNaik->listMesin->code ?? '-');
                $badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            } elseif ($rak && $rak->status === 'TERISI') {
                $status = 'Di Rak';
                $lokasi = 'Rak ' . ($rak->listRak->rak ?? $rak->rak ?? '-') . ' (No. ' . ($rak->listNoRak->norak ?? $rak->norak ?? '-') . ')';
                $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
            } else {
                $status = 'Non-Aktif';
                $lokasi = 'Workshop Area';
                $badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'total_masak' => $totalMasak,
                'tgl_masak' => $tglMasak,
                'total_sandblasting' => $totalSandblasting,
                'total_repair' => $totalRepair,
                'tgl_repair' => $tglRepair,
                'status' => $status,
                'lokasi' => $lokasi,
                'badge_class' => $badgeClass,
            ];
        });
    }

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

        // Optimized subquery execution
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

        $reportMolds = $this->getDashboardReportMolds();

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
            'recentCetakanNaik',
            'reportMolds'
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

        $reportMolds = $this->getDashboardReportMolds();

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
            'reportMolds' => $reportMolds,
        ]);
    }
}
