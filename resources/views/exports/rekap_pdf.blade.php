<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Tahun {{ $tahun }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Rekapitulasi Tahun {{ $tahun }}</h2>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama Peserta</th>
                <th>CU</th>
                <th>PI</th>
                <th>BI</th>
                <th>Total</th>
                <th>Status CU</th>
                <th>Ronde</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->peserta->user->name ?? '-' }}</td>
                    <td>{{ number_format($r->skor_cu_normal, 4) }}</td>
                    <td>{{ number_format($r->skor_pi_normal, 4) }}</td>
                    <td>{{ number_format($r->skor_bi_normal, 4) }}</td>
                    <td>{{ number_format($r->total_akhir, 4) }}</td>
                    <td>{{ ucfirst($r->status_cu) }}</td>
                    <td>{{ $r->selection_round }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
