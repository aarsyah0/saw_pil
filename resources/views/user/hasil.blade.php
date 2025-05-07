{{-- resources/views/user/hasil.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Hasil')
@section('page_title', 'Hasil Perhitungan')

@section('content')
    @php
        $userId = auth()->id();
        $selection = \App\Models\CuSelection::where('peserta_id', $userId)->latest('selection_round')->first();
        $submission = null;
        $rankings = collect();

        if ($selection && $selection->status_lolos === 'lolos') {
            $submission = \App\Models\CuSubmission::where('peserta_id', $userId)
                ->where('status', 'approved')
                ->latest('submitted_at')
                ->first();

            $rankings = \App\Models\PenilaianAkhir::join(
                'peserta_profile as pp',
                'penilaian_akhir.peserta_id',
                'pp.user_id',
            )
                ->join('users as u', 'pp.user_id', 'u.id')
                ->whereIn('penilaian_akhir.peserta_id', function ($q) {
                    $q->select('peserta_id')->from('cu_selection')->where('status_lolos', 'lolos');
                })
                ->orderByDesc('penilaian_akhir.total_akhir')
                ->select([
                    'penilaian_akhir.peserta_id',
                    'u.name',
                    'penilaian_akhir.skor_cu_normal',
                    'penilaian_akhir.skor_pi_normal',
                    'penilaian_akhir.skor_bi_normal',
                    'penilaian_akhir.total_akhir',
                ])
                ->get();
        }
    @endphp

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Card 1: Status CU Selection --}}
        <div
            class="p-6 rounded-2xl shadow-md
            @if (!$selection) bg-gray-50 border-l-4 border-yellow-400
            @elseif($selection->status_lolos === 'lolos') bg-green-50 border-l-4 border-green-500
            @elseif($selection->status_lolos === 'gagal') bg-red-50 border-l-4 border-red-500
            @else bg-yellow-50 border-l-4 border-yellow-500 @endif">
            <div class="text-center text-lg font-medium">
                @if (!$selection)
                    Data seleksi CU belum tersedia.
                @elseif($selection->status_lolos === 'lolos')
                    <span class="text-green-700">🎉 Selamat! Anda <strong>LOLOS</strong> tahap CU selection.</span>
                @elseif($selection->status_lolos === 'gagal')
                    <span class="text-red-700">😞 Maaf, Anda <strong>TIDAK LOLOS</strong> tahap CU selection.</span>
                @else
                    <span class="text-yellow-700">🔄 Status seleksi CU Anda masih <strong>PENDING</strong>.</span>
                @endif
            </div>
        </div>

        @if ($selection && $selection->status_lolos === 'lolos')
            {{-- Card 2: Detail Hasil CU --}}
            <div class="p-6 bg-white rounded-2xl shadow-md border border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Detail Hasil CU</h3>

                @if ($submission)
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Waktu Submit:</strong> {{ $submission->submitted_at->format('d M Y, H:i') }}</li>
                        <li><strong>Status Review:</strong> {{ ucfirst($submission->status) }}</li>
                        <li><strong>Skor CU Anda:</strong> {{ number_format($selection->skor_cu, 4) }}</li>
                    </ul>
                    <p class="mt-4 text-gray-600">
                        Silakan tunggu jadwal tahap berikutnya (PI &amp; BI). Informasi akan diumumkan di halaman<br>
                        <a href="{{ route('user.jadwal') }}" class="text-blue-600 hover:underline">Jadwal</a>
                    </p>
                @else
                    <p class="text-gray-600">
                        Anda belum memiliki submission CU yang disetujui. Silakan periksa kembali file CU Anda.
                    </p>
                @endif
            </div>

            {{-- Card 3: Tahap 2 — Perankingan Nilai Akhir --}}
            <div class="p-6 bg-white rounded-2xl shadow-md border border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Tahap 2: Perankingan Nilai Akhir</h3>

                @if ($rankings->isEmpty())
                    <p class="text-gray-500">Data perhitungan akhir belum tersedia.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Rank</th>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">CU (Norm)</th>
                                    <th class="px-4 py-2">PI (Norm)</th>
                                    <th class="px-4 py-2">BI (Norm)</th>
                                    <th class="px-4 py-2">Total Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rankings as $i => $r)
                                    <tr class="@if ($i % 2 == 0) bg-white @else bg-gray-50 @endif">
                                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                                        <td class="px-4 py-2">{{ $r->name }}</td>
                                        <td class="px-4 py-2">{{ number_format($r->skor_cu_normal, 3) }}</td>
                                        <td class="px-4 py-2">{{ number_format($r->skor_pi_normal, 3) }}</td>
                                        <td class="px-4 py-2">{{ number_format($r->skor_bi_normal, 3) }}</td>
                                        <td class="px-4 py-2 font-semibold">{{ number_format($r->total_akhir, 3) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

    </div>
@endsection
