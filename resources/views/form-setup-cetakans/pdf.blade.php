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
                <th>NO DOC</th>
                <th>TANGGAL</th>
                <th>KATEGORI</th>
                <th>CODE ITEM</th>
                <th>MOLD SET</th>
                <th>MOLD CAVITY</th>
                <th>MESIN</th>
                <th>SHIFT</th>
                <th class="text-center">GUIDE PEN</th>
                <th class="text-center">BUSING</th>
                <th class="text-center">BAUT</th>
                <th class="text-center">CORE</th>
                <th class="text-center">PISTON</th>
                <th class="text-center">POT</th>
                <th class="text-center">PL</th>
                <th class="text-center">CAV NG</th>
                <th>PIC KARYAWAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td><strong>{{ $item->nodoc }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->kategori->name ?? '-' }}</td>
                    <td><strong>{{ $item->listCodeItem->name ?? '-' }}</strong></td>
                    <td>{{ $item->setCodeItem->moldset ?? '-' }}</td>
                    <td>{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                    <td>{{ $item->listMesin->code ?? '-' }}</td>
                    <td class="text-center">{{ $item->shift }}</td>
                    <td class="text-center">{{ $item->guidepen ?? '-' }}</td>
                    <td class="text-center">{{ $item->busing ?? '-' }}</td>
                    <td class="text-center">{{ $item->baut ?? '-' }}</td>
                    <td class="text-center">{{ $item->core ?? '-' }}</td>
                    <td class="text-center">{{ $item->piston ?? '-' }}</td>
                    <td class="text-center">{{ $item->pot ?? '-' }}</td>
                    <td class="text-center">{{ $item->pl ?? '-' }}</td>
                    <td class="text-center">{{ $item->cav_ng ?? 0 }}</td>
                    <td>{{ $item->detailUser->pluck('name')->implode(', ') ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen resmi digenerate otomatis oleh Mold Management System - PT. IRC INOAC INDONESIA
    </div>
</body>
</html>
