@extends('admin.layouts.master')

@section('title', 'Rekap Tahun ' . $tahun)

@section('content')
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-600"></i>
                Rekapitulasi Tahun {{ $tahun }}
            </h2>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.rekap.index') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>


    <div class="overflow-x-auto bg-white rounded-lg shadow border">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 uppercase text-xs font-semibold text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-center">Rank</th>
                    <th class="px-4 py-3 text-left">Peserta</th>
                    <th class="px-4 py-3 text-center">CU</th>
                    <th class="px-4 py-3 text-center">PI</th>
                    <th class="px-4 py-3 text-center">BI</th>
                    <th class="px-4 py-3 text-center">Total SAW</th>
                    <th class="px-4 py-3 text-center">Status CU</th>
                    <th class="px-4 py-3 text-center">Ronde</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekap as $r)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-center font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $r->peserta->user->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($r->skor_cu_normal, 4) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($r->skor_pi_normal, 4) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($r->skor_bi_normal, 4) }}</td>
                        <td class="px-4 py-2 text-center font-bold text-gray-800">
                            {{ number_format($r->total_akhir, 4) }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($r->status_cu == 'lolos')
                                <span
                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Lolos
                                </span>
                            @elseif ($r->status_cu == 'gagal')
                                <span
                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                    <i class="fas fa-times-circle mr-1"></i> Gagal
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">{{ $r->selection_round }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i> Belum ada data rekap tahun ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Tombol Unduh di Bawah --}}
    <div class="mt-8 flex flex-col sm:flex-row sm:justify-end gap-4">
        <a href="{{ route('admin.rekap.export', $tahun) }}"
            class="flex items-center gap-3 bg-green-100 text-green-800 hover:bg-green-200 transition px-5 py-3 rounded-lg shadow-sm border border-green-300">
            <i class="fas fa-file-excel fa-lg"></i>
            <div class="text-left text-sm leading-tight">
                <div class="font-semibold">Unduh Excel</div>
                <small class="text-green-600">.xlsx format</small>
            </div>
        </a>

        <a href="{{ route('admin.rekap.pdf', $tahun) }}"
            class="flex items-center gap-3 bg-red-100 text-red-800 hover:bg-red-200 transition px-5 py-3 rounded-lg shadow-sm border border-red-300">
            <i class="fas fa-file-pdf fa-lg"></i>
            <div class="text-left text-sm leading-tight">
                <div class="font-semibold">Unduh PDF</div>
                <small class="text-red-600">.pdf format</small>
            </div>
        </a>
    </div>

@endsection
