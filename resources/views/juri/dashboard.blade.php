@extends('juri.layouts.master')

@section('title', 'Dashboard Juri')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-6 rounded-3xl shadow-lg">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-4xl font-extrabold text-gray-900">Dashboard</h1>
                <div class="text-gray-800 text-lg">
                    Good morning, <strong class="font-semibold">{{ Auth::user()->name }}</strong>
                </div>
            </div>
        </div>

        {{-- Ringkasan Kartu Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 justify-center mx-auto max-w-4xl">
            {{-- Card: Peserta Lolos --}}
            <div class="bg-white p-6 rounded-3xl shadow-lg flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-600 uppercase">Peserta Lolos CU</h3>
                    <p class="mt-2 text-5xl font-bold text-blue-600">{{ $passedCount }}</p>
                </div>
                <div class="p-4 bg-blue-100 rounded-full">
                    <i class="bi bi-people-fill text-3xl text-blue-500"></i>
                </div>
            </div>

            {{-- Card: Jadwal Total --}}
            <div class="bg-white p-6 rounded-3xl shadow-lg flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-600 uppercase">Total Jadwal Anda</h3>
                    <p class="mt-2 text-5xl font-bold text-green-600">{{ $schedules->count() }}</p>
                </div>
                <div class="p-4 bg-green-100 rounded-full">
                    <i class="bi bi-calendar-check-fill text-3xl text-green-500"></i>
                </div>
            </div>

        </div>

        {{-- Jadwal Penilaian PI/BI --}}
        <div class="bg-white p-6 rounded-3xl shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Penilaian Anda</h2>
            @if ($schedules->isEmpty())
                <p class="text-gray-500">Tidak ada jadwal penilaian untuk Anda.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">#
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">
                                    Nama Peserta</th>
                                <th
                                    class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">
                                    Lokasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($schedules as $idx => $s)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $s->peserta_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                        {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                        {{ $s->lokasi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
