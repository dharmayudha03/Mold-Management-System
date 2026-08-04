<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Tanggal Aktivitas & History Cetakan - PT IRC INOAC INDONESIA</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 15px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 16px; color: #0f172a; text-transform: uppercase; }
        .header h2 { margin: 3px 0 0 0; font-size: 11px; color: #4f46e5; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; font-size: 9px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background-color: #f1f5f9; font-weight: bold; text-transform: uppercase; font-size: 8.5px; color: #334155; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .footer { margin-top: 25px; font-size: 9px; color: #64748b; text-align: right; }
        @media print {
            @page { size: A4 landscape; margin: 12mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="background: #4f46e5; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
            Cetak / Download PDF
        </button>
    </div>

    <div class="header">
        <h1>PT. IRC INOAC INDONESIA</h1>
        <h2>MOLD SYSTEM MANAGEMENT - LAPORAN TANGGAL AKTIVITAS, LOKASI & REKAP PERBAIKAN CETAKAN</h2>
        <p>
            Periode Laporan: 
            <strong>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua Periode' }}</strong>
            s/d 
            <strong>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Hari Ini' }}</strong>
            | Dicetak Pada: {{ date('d F Y H:i:s') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">NO</th>
                <th style="width: 15%;">CODE ITEM</th>
                <th style="width: 20%;">LOKASI SAAT INI / POSISI</th>
                <th style="width: 11%;">TGL NAIK</th>
                <th style="width: 11%;">TGL SANDBLAST</th>
                <th style="width: 11%;">TGL REPAIR</th>
                <th class="text-center" style="width: 7%;">MASAK</th>
                <th class="text-center" style="width: 8%;">SANDBLAST</th>
                <th class="text-center" style="width: 7%;">PEJO</th>
                <th class="text-center" style="width: 7%;">MJO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($codeItems as $idx => $item)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->tgl_naik_terakhir }}</td>
                    <td>{{ $item->tgl_sandblasting_terakhir }}</td>
                    <td>{{ $item->tgl_repair_terakhir }}</td>
                    <td class="text-center"><strong>{{ $item->total_masak }}x</strong></td>
                    <td class="text-center"><strong>{{ $item->total_sandblasting }}x</strong></td>
                    <td class="text-center"><strong>{{ $item->total_pejo }}x</strong></td>
                    <td class="text-center"><strong>{{ $item->total_mjo }}x</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen resmi digenerate otomatis oleh Mold Management System - PT. IRC INOAC INDONESIA
    </div>
</body>
</html>
