<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Form Setup Cetakan - PT IRC INOAC INDONESIA</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9.5px; color: #1e293b; margin: 0; padding: 12px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 8px; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 15px; color: #0f172a; text-transform: uppercase; }
        .header h2 { margin: 3px 0 0 0; font-size: 11px; color: #4f46e5; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; font-size: 8.5px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #cbd5e1; padding: 5px 5px; text-align: left; font-size: 9px; }
        th { background-color: #f1f5f9; font-weight: bold; text-transform: uppercase; font-size: 8.5px; color: #334155; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 8.5px; color: #64748b; text-align: right; }
        @media print {
            @page { size: A4 landscape; margin: 8mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 12px; text-align: right;">
        <button onclick="window.print()" style="background: #4f46e5; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
            Cetak / Download PDF
        </button>
    </div>

    <div class="header">
        <h1>PT. IRC INOAC INDONESIA</h1>
        <h2>LAPORAN FORM SETUP CETAKAN</h2>
        <p>Dicetak Pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">Tanggal</th>
                <th>Kategori</th>
                <th class="text-center">Shift</th>
                <th>Nama Karyawan</th>
                <th class="text-center">Code Item</th>
                <th class="text-center">Mold Set</th>
                <th class="text-center">Mold Cav</th>
                <th class="text-center">No Mesin</th>
                <th class="text-center">Cav NG</th>
                <th class="text-center">Guide Pen</th>
                <th class="text-center">Busing</th>
                <th class="text-center">Baut / Mur</th>
                <th class="text-center">Core</th>
                <th class="text-center">Piston</th>
                <th class="text-center">Pot</th>
                <th class="text-center">PL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @php
                    $formatCheck = function($val) {
                        if (empty($val) || $val === '-' || strtoupper($val) === 'NG' || $val === '0') {
                            return '-';
                        }
                        return '√';
                    };
                @endphp
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ strtoupper($item->kategori->name ?? '-') }}</td>
                    <td class="text-center">{{ $item->shift }}</td>
                    <td>{{ $item->detailUser->pluck('name')->implode(', ') ?: '-' }}</td>
                    <td class="text-center"><strong>{{ $item->listCodeItem->name ?? '-' }}</strong></td>
                    <td class="text-center">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                    <td class="text-center">{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                    <td class="text-center">{{ $item->listMesin->code ?? '-' }}</td>
                    <td class="text-center">{{ $item->cav_ng ?? 0 }}</td>
                    <td class="text-center">{{ $formatCheck($item->guidepen) }}</td>
                    <td class="text-center">{{ $formatCheck($item->busing) }}</td>
                    <td class="text-center">{{ $formatCheck($item->baut) }}</td>
                    <td class="text-center">{{ $formatCheck($item->core) }}</td>
                    <td class="text-center">{{ $formatCheck($item->piston) }}</td>
                    <td class="text-center">{{ $formatCheck($item->pot) }}</td>
                    <td class="text-center">{{ $formatCheck($item->pl) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen resmi digenerate otomatis oleh Mold Management System - PT. IRC INOAC INDONESIA
    </div>
</body>
</html>
