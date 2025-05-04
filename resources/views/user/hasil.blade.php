{{-- resources/views/user/hasil.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Hasil')
@section('page_title', 'Hasil Perhitungan')

@section('content')
    @php
        $userId = auth()->id();

        // Ambil record CU selection terbaru untuk peserta ini
        $selection = \App\Models\CuSelection::where('peserta_id', $userId)->latest('selection_round')->first();

        // Ambil detail submission CU jika lolos
        $submission = null;
        if ($selection && $selection->status_lolos === 'lolos') {
            $submission = \App\Models\CuSubmission::where('peserta_id', $userId)
                ->where('status', 'approved')
                ->latest('submitted_at')
                ->first();

            // Siapkan data perhitungan tahap kedua (PI & BI) hanya jika CU lolos
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

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg space-y-8">
        {{-- Status CU Selection --}}
        <div
            class="text-center p-4 rounded-lg
            @if ($selection && $selection->status_lolos == 'lolos') bg-green-100 border border-green-200 text-green-800
            @elseif($selection && $selection->status_lolos == 'gagal') bg-red-100 border border-red-200 text-red-800
            @else bg-yellow-100 border border-yellow-200 text-yellow-800 @endif">
            @if (!$selection)
                Data seleksi CU belum tersedia.
            @elseif($selection->status_lolos === 'lolos')
                <span class="font-semibold">Selamat! Anda <u>LOLOS</u> tahap CU selection.</span>
            @elseif($selection->status_lolos === 'gagal')
                <span class="font-semibold">Maaf, Anda <u>TIDAK LOLOS</u> tahap CU selection.</span>
            @else
                <span>Status seleksi CU Anda masih <u>PENDING</u>.</span>
            @endif
        </div>

        @if ($selection && $selection->status_lolos === 'lolos')
            {{-- Detail Hasil CU --}}
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner space-y-4">
                <h3 class="text-xl font-semibold">Detail Hasil CU</h3>

                @if ($submission)
                    <ul class="space-y-2">
                        <li><strong>Waktu Submit:</strong> {{ $submission->submitted_at->format('d M Y, H:i') }}</li>
                        <li><strong>Status Review:</strong> {{ ucfirst($submission->status) }}</li>
                        <li><strong>Skor CU Anda:</strong> {{ number_format($selection->skor_cu, 4) }}</li>
                    </ul>
                    <p class="mt-4 text-gray-700">
                        Silakan tunggu jadwal tahap berikutnya (PI &amp; BI).
                        Informasi jadwal akan diumumkan di halaman
                        Jadwal
                    </p>
                @else
                    <p class="text-gray-700">
                        Anda belum memiliki submission CU yang disetujui.
                        Silakan periksa kembali file CU Anda.
                    </p>
                @endif
            </div>

            {{-- Tahap 2: Perankingan Nilai Akhir --}}
            <div class="space-y-4">
                <h3 class="text-xl font-semibold">Tahap 2: Perankingan Nilai Akhir</h3>

                @if ($rankings->isEmpty())
                    <p class="text-gray-500">Data perhitungan akhir belum tersedia.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr class="text-left">
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
