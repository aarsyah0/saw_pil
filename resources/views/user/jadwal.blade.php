{{-- resources/views/user/jadwal.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Jadwal Pelaksanaan')
@section('page_title', 'Jadwal Pelaksanaan')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-lg space-y-6">
        <h2 class="text-2xl font-semibold mb-4">Jadwal Pribadi Seleksi PI & BI</h2>

        @if ($schedules->isEmpty())
            <p class="text-gray-500">Belum ada jadwal PI & BI yang dijadwalkan untuk Anda.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">waktu</th>
                            <th class="px-4 py-2">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $i => $sch)
                            <tr class="@if ($i % 2 == 0) bg-white @else bg-gray-50 @endif">
                                <td class="px-4 py-2">{{ $i + 1 }}</td>
                                <td class="px-4 py-2">{{ $sch->tanggal->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $sch->tanggal->format('H:i') }}</td>
                                <td class="px-4 py-2">{{ $sch->lokasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
