<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Form Sandblasting - PT IRC INOAC INDONESIA</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #0f172a; text-transform: uppercase; }
        .header h2 { margin: 4px 0 0 0; font-size: 13px; color: #d97706; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; font-size: 10px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 7px 9px; text-align: left; }
        th { background-color: #f1f5f9; font-weight: bold; text-transform: uppercase; font-size: 10px; color: #334155; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; font-size: 10px; color: #64748b; text-align: right; }
        @media print {
            @page { size: A4 landscape; margin: 15mm; }
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
        <h2>LAPORAN FORM SANDBLASTING</h2>
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
                <th>PIC KARYAWAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td><strong>{{ $item->nodoc }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->kategori->name ?? '-' }}</td>
                    <td><strong>{{ $item->listCodeItem->name ?? '-' }}</strong></td>
                    <td>{{ $item->setCodeItem->moldset ?? '-' }}</td>
                    <td>{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                    <td>{{ $item->listMesin->code ?? '-' }}</td>
                    <td class="text-center">{{ $item->shift }}</td>
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
