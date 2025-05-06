@extends('juri.layouts.master')

@section('title', 'Dashboard Juri')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Dashboard Juri</h2>

        {{-- Ringkasan CU --}}
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-700">
                Jumlah peserta lolos CU: <span class="font-bold">{{ $passedCount }}</span>
            </p>
        </div>

        {{-- Jadwal PI/BI --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-2">Jadwal Penilaian PI/BI</h3>
            @if ($schedules->isEmpty())
                <p class="text-gray-600">Belum ada jadwal penilaian.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($schedules as $i => $sch)
                                <tr class="{{ $i % 2 == 0 ? 'bg-gray-50' : '' }}">
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $sch->peserta_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($sch->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $sch->lokasi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Ranking Nilai Akhir --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">Ranking Nilai Akhir</h3>
            @if ($rankings->isEmpty())
                <p class="text-gray-600">Belum ada data penilaian akhir.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-purple-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Peserta</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Nilai CU (%)
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Nilai PI (%)
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Nilai BI (%)
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Total Akhir (%)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($rankings as $i => $r)
                                <tr class="{{ $i % 2 == 0 ? 'bg-gray-50' : '' }}">
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $r->peserta_name }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        {{ number_format($r->skor_cu_normal * 100, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        {{ number_format($r->skor_pi_normal * 100, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        {{ number_format($r->skor_bi_normal * 100, 2) }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-right">
                                        {{ number_format($r->total_akhir, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
