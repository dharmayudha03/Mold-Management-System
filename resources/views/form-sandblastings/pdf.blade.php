<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Form Sandblasting - PT IRC INOAC INDONESIA</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 15px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 16px; color: #0f172a; text-transform: uppercase; }
        .header h2 { margin: 3px 0 0 0; font-size: 12px; color: #d97706; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; font-size: 9px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 6px; text-align: left; font-size: 9.5px; }
        th { background-color: #f1f5f9; font-weight: bold; text-transform: uppercase; font-size: 9px; color: #334155; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .footer { margin-top: 25px; font-size: 9px; color: #64748b; text-align: right; }
        @media print {
            @page { size: A4 landscape; margin: 10mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="background: #d97706; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
            Cetak / Download PDF
        </button>
    </div>

    <div class="header">
        <h1>PT. IRC INOAC INDONESIA</h1>
        <h2>LAPORAN FORM SANDBLASTING CETAKAN</h2>
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
                <th class="text-center">RAK</th>
                <th class="text-center">No RAK</th>
                <th class="text-center">Cav NG</th>
                <th class="text-center">Sandblasting</th>
                <th class="text-center">Cuci</th>
                <th class="text-center">Autosol</th>
                <th class="text-center">Gerinda</th>
                <th class="text-center">Oiling</th>
                <th>Keterangan</th>
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
                    <td class="text-center">{{ $item->rak ?? '-' }}</td>
                    <td class="text-center">{{ $item->norak ?? '-' }}</td>
                    <td class="text-center">{{ $item->cav_ng ?? 0 }}</td>
                    <td class="text-center">{{ $formatCheck($item->sandblasting) }}</td>
                    <td class="text-center">{{ $formatCheck($item->cuci) }}</td>
                    <td class="text-center">{{ $formatCheck($item->autosol) }}</td>
                    <td class="text-center">{{ $formatCheck($item->gerinda) }}</td>
                    <td class="text-center">{{ $formatCheck($item->oiling) }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen resmi digenerate otomatis oleh Mold Management System - PT. IRC INOAC INDONESIA
    </div>
</body>
</html>
