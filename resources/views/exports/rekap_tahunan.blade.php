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
        @foreach ($rekap as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $r->peserta->user->name ?? '-' }}</td>
                <td>{{ number_format($r->skor_cu_normal, 4) }}</td>
                <td>{{ number_format($r->skor_pi_normal, 4) }}</td>
                <td>{{ number_format($r->skor_bi_normal, 4) }}</td>
                <td>{{ number_format($r->total_akhir, 4) }}</td>
                <td>{{ $r->status_cu }}</td>
                <td>{{ $r->selection_round }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
