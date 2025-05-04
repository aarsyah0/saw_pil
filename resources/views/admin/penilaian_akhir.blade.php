@extends('admin.layouts.master')

@section('title', 'Perangkingan Akhir')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Perangkingan Akhir (SAW)</h2>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow mb-8">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Rank</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Peserta</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">CU<sub>norm</sub></th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">PI<sub>norm</sub></th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">BI<sub>norm</sub></th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Total SAW</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $row->rank }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $row->peserta->nama_pt ?? $row->peserta->user->name }}
                        </td>
                        <td class="px-6 py-4 text-center">{{ number_format($row->norm['CU'], 4) }}</td>
                        <td class="px-6 py-4 text-center">{{ number_format($row->norm['PI'], 4) }}</td>
                        <td class="px-6 py-4 text-center">{{ number_format($row->norm['BI'], 4) }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ number_format($row->computed_total, 4) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data penilaian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Matrix Penilaian --}}
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Matrix Penilaian SAW</h3>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Peserta</th>
                        @foreach (['CU', 'PI', 'BI'] as $k)
                            <th class="px-4 py-2 text-center">{{ $k }}<sub>norm</sub></th>
                            <th class="px-4 py-2 text-center">
                                {{ $k }}<sub>×{{ number_format($bobot[$k], 2) }}</sub>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matrix as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $row['peserta'] }}</td>
                            @foreach (['CU', 'PI', 'BI'] as $k)
                                <td class="px-4 py-2 text-center">{{ number_format($row['norm'][$k], 4) }}</td>
                                <td class="px-4 py-2 text-center">{{ number_format($row['weighted'][$k], 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
