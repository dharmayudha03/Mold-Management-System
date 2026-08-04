<?php

namespace App\Http\Controllers;

use App\Models\ListCodeItem;
use App\Models\CetakanNaik;
use App\Models\FormSandblasting;
use App\Models\FormRepairCetakan;
use App\Models\FormMjo;
use App\Models\FormSetupCetakan;
use App\Models\PenomoranRak;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class ReportController extends Controller
{
    private function getFilteredData(Request $request, $paginate = true)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $startCodeId = $request->query('start_code_item_id');
        $endCodeId = $request->query('end_code_item_id');
        $statusFilter = $request->query('status_filter'); // 'all', 'produksi', 'rak'
        $search = $request->query('search');

        $query = ListCodeItem::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($startCodeId) {
            $query->where('id', '>=', $startCodeId);
        }

        if ($endCodeId) {
            $query->where('id', '<=', $endCodeId);
        }

        $query->orderBy('name', 'asc');

        $itemsQuery = $paginate ? $query->paginate(20)->withQueryString() : $query->get();

        $collection = $paginate ? $itemsQuery->getCollection() : $itemsQuery;

        $collection->transform(function ($item) use ($startDate, $endDate) {
            // Masak (Cetakan Naik) Query & Last Date
            $masakQuery = CetakanNaik::where('list_code_item_id', $item->id);
            if ($startDate) $masakQuery->whereDate('tanggalnaik', '>=', $startDate);
            if ($endDate) $masakQuery->whereDate('tanggalnaik', '<=', $endDate);
            $item->total_masak = $masakQuery->count();
            
            $lastMasak = CetakanNaik::where('list_code_item_id', $item->id)->latest('tanggalnaik')->first();
            $item->tgl_naik_terakhir = $lastMasak ? Carbon::parse($lastMasak->tanggalnaik)->format('d/m/Y') : '-';

            // Sandblasting Query & Last Date
            $sandQuery = FormSandblasting::where('list_code_item_id', $item->id);
            if ($startDate) $sandQuery->whereDate('tanggal', '>=', $startDate);
            if ($endDate) $sandQuery->whereDate('tanggal', '<=', $endDate);
            $item->total_sandblasting = $sandQuery->count();

            $lastSand = FormSandblasting::where('list_code_item_id', $item->id)->latest('tanggal')->first();
            $item->tgl_sandblasting_terakhir = $lastSand ? Carbon::parse($lastSand->tanggal)->format('d/m/Y') : '-';

            // PEJO Repair Query (Pengajuan Repair) & Last Date
            $repairQuery = FormRepairCetakan::where('list_code_item_id', $item->id);
            if ($startDate) $repairQuery->whereDate('tanggal', '>=', $startDate);
            if ($endDate) $repairQuery->whereDate('tanggal', '<=', $endDate);
            $item->total_pejo = $repairQuery->count();

            $lastPejo = FormRepairCetakan::where('list_code_item_id', $item->id)->latest('tanggal')->first();

            // MJO Repair Query (Pengerjaan Repair Mold Shops) & Last Date
            $mjoQuery = FormMjo::where('list_code_item_id', $item->id);
            if ($startDate) $mjoQuery->whereDate('tanggal', '>=', $startDate);
            if ($endDate) $mjoQuery->whereDate('tanggal', '<=', $endDate);
            $item->total_mjo = $mjoQuery->count();

            $lastMjo = FormMjo::where('list_code_item_id', $item->id)->latest('tanggal')->first();

            // Determine Last Repair Date (Latest between PEJO & MJO)
            $pejoTime = $lastPejo ? strtotime($lastPejo->tanggal) : 0;
            $mjoTime = $lastMjo ? strtotime($lastMjo->tanggal) : 0;
            if ($pejoTime || $mjoTime) {
                $item->tgl_repair_terakhir = ($pejoTime >= $mjoTime)
                    ? Carbon::parse($lastPejo->tanggal)->format('d/m/Y')
                    : Carbon::parse($lastMjo->tanggal)->format('d/m/Y');
            } else {
                $item->tgl_repair_terakhir = '-';
            }

            // Setup Query & Last Date
            $setupQuery = FormSetupCetakan::where('list_code_item_id', $item->id);
            if ($startDate) $setupQuery->whereDate('tanggal', '>=', $startDate);
            if ($endDate) $setupQuery->whereDate('tanggal', '<=', $endDate);
            $item->total_setup = $setupQuery->count();

            // Location & Active Status Check
            $activeNaik = CetakanNaik::where('list_code_item_id', $item->id)
                ->where('keterangan', '!=', 'Tidak Produksi')
                ->where('keterangan', '!=', 'BELUM MASAK')
                ->with('listMesin')
                ->latest()
                ->first();

            $rak = PenomoranRak::where('list_code_item_id', $item->id)->with(['listRak', 'listNoRak'])->first();

            if ($activeNaik) {
                $item->status_aktif = 'Sedang Masak / Produksi';
                $item->lokasi = 'Mesin ' . ($activeNaik->listMesin->code ?? '-');
                $item->status_type = 'produksi';
            } elseif ($rak && $rak->status === 'TERISI') {
                $item->status_aktif = 'Tersimpan di Rak';
                $item->lokasi = 'Rak ' . ($rak->listRak->rak ?? $rak->rak ?? '-') . ' (No. ' . ($rak->listNoRak->norak ?? $rak->norak ?? '-') . ')';
                $item->status_type = 'rak';
            } else {
                $item->status_aktif = 'Non-Aktif';
                $item->lokasi = 'Workshop / Storage Area';
                $item->status_type = 'workshop';
            }

            return $item;
        });

        return $itemsQuery;
    }

    public function moldReport(Request $request)
    {
        $allCodeItems = ListCodeItem::orderBy('name', 'asc')->get();
        $codeItems = $this->getFilteredData($request, true);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $startCodeId = $request->query('start_code_item_id');
        $endCodeId = $request->query('end_code_item_id');
        $statusFilter = $request->query('status_filter', 'all');
        $search = $request->query('search');

        return view('reports.molds', compact(
            'codeItems', 'allCodeItems', 'startDate', 'endDate',
            'startCodeId', 'endCodeId', 'statusFilter', 'search'
        ));
    }

    public function historyLog(ListCodeItem $listCodeItem)
    {
        $events = [];

        // 1. Cetakan Naik
        $naiks = CetakanNaik::where('list_code_item_id', $listCodeItem->id)->with('listMesin')->get();
        foreach ($naiks as $n) {
            $events[] = [
                'type' => 'CETAKAN NAIK',
                'title' => 'Cetakan Naik / Produksi',
                'date' => Carbon::parse($n->tanggalnaik)->format('d M Y'),
                'raw_date' => $n->tanggalnaik,
                'detail' => 'Mesin: ' . ($n->listMesin->code ?? '-') . ' (' . ($n->keterangan ?? 'Produksi') . ')',
                'badge' => 'bg-primary text-white'
            ];
        }

        // 2. Sandblasting
        $sands = FormSandblasting::where('list_code_item_id', $listCodeItem->id)->get();
        foreach ($sands as $s) {
            $events[] = [
                'type' => 'SANDBLASTING',
                'title' => 'Sandblasting Cetakan (' . $s->nodoc . ')',
                'date' => Carbon::parse($s->tanggal)->format('d M Y'),
                'raw_date' => $s->tanggal,
                'detail' => 'Shift ' . $s->shift . ' | Oiling: ' . $s->oiling . ($s->rak ? (' | Storage: ' . $s->rak . ' No ' . $s->norak) : ''),
                'badge' => 'bg-warning text-dark'
            ];
        }

        // 3. PEJO Repair
        $pejos = FormRepairCetakan::where('list_code_item_id', $listCodeItem->id)->get();
        foreach ($pejos as $p) {
            $events[] = [
                'type' => 'PEJO REPAIR',
                'title' => 'Pengajuan Repair Cetakan (' . $p->nodoc . ')',
                'date' => Carbon::parse($p->tanggal)->format('d M Y'),
                'raw_date' => $p->tanggal,
                'detail' => 'Problem: ' . ($p->masalah ?? $p->problem ?? '-') . ' | Status: ' . ($p->status ?? 'Pengajuan'),
                'badge' => 'bg-danger text-white'
            ];
        }

        // 4. MJO Mold Shop Repair
        $mjos = FormMjo::where('list_code_item_id', $listCodeItem->id)->get();
        foreach ($mjos as $m) {
            $events[] = [
                'type' => 'MJO REPAIR',
                'title' => 'Perbaikan Mold Shop (' . $m->nodoc . ')',
                'date' => Carbon::parse($m->tanggal)->format('d M Y'),
                'raw_date' => $m->tanggal,
                'detail' => 'Penanganan: ' . ($m->penanganan ?? '-') . ' | Status: ' . ($m->status ?? 'Proses'),
                'badge' => 'bg-info text-white'
            ];
        }

        // 5. Form Setup
        $setups = FormSetupCetakan::where('list_code_item_id', $listCodeItem->id)->with('kategori')->get();
        foreach ($setups as $st) {
            $events[] = [
                'type' => 'SETUP CETAKAN',
                'title' => 'Setup Cetakan (' . ($st->kategori->name ?? 'Setup') . ')',
                'date' => Carbon::parse($st->tanggal)->format('d M Y'),
                'raw_date' => $st->tanggal,
                'detail' => 'No Doc: ' . $st->nodoc . ($st->rak ? (' | Rak: ' . $st->rak . ' No ' . $st->norak) : ''),
                'badge' => 'bg-success text-white'
            ];
        }

        // Sort events descending by raw_date
        usort($events, function ($a, $b) {
            return strtotime($b['raw_date']) - strtotime($a['raw_date']);
        });

        return response()->json($events);
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'Laporan_Rekap_Cetakan_' . date('Ymd_His') . '.csv';
        $codeItems = $this->getFilteredData($request, false);

        $response = new StreamedResponse(function () use ($codeItems) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'NO',
                'CODE ITEM',
                'STATUS CETAKAN',
                'LOKASI TERAKHIR / POSISI',
                'TGL NAIK TERAKHIR',
                'TGL SANDBLASTING TERAKHIR',
                'TGL REPAIR TERAKHIR',
                'TOTAL MASAK (NAIK)',
                'TOTAL SANDBLASTING',
                'TOTAL PEJO (REPAIR)',
                'TOTAL MJO (MOLD SHOP)',
                'TOTAL SETUP'
            ]);

            $no = 1;
            foreach ($codeItems as $item) {
                fputcsv($handle, [
                    $no++,
                    $item->name,
                    $item->status_aktif,
                    $item->lokasi,
                    $item->tgl_naik_terakhir,
                    $item->tgl_sandblasting_terakhir,
                    $item->tgl_repair_terakhir,
                    $item->total_masak,
                    $item->total_sandblasting,
                    $item->total_pejo,
                    $item->total_mjo,
                    $item->total_setup
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

    public function printPdf(Request $request)
    {
        $codeItems = $this->getFilteredData($request, false);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return view('reports.pdf_molds', compact('codeItems', 'startDate', 'endDate'));
    }
}
