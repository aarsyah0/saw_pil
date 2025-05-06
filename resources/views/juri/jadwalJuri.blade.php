@extends('juri.layouts.master')

@section('title', 'Jadwal Juri')

@section('content')
    <div class="bg-[#E7EFF6] p-6 rounded-3xl shadow-lg flex items-center justify-between">
        <h1 class="text-3xl font-extrabold text-gray-900">Daftar Jadwal</h1>
    </div>
    <div class="container mx-auto py-6">

        @if ($schedules->isEmpty())
            <p class="text-gray-600">Belum ada jadwal penilaian.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">#</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">Nama Peserta</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $index => $schedule)
                            <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : '' }}">
                                <td class="px-6 py-4 border-b text-sm">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 border-b text-sm">{{ $schedule->peserta_name }}</td>
                                <td class="px-6 py-4 border-b text-sm">
                                    {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4 border-b text-sm">{{ $schedule->lokasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
