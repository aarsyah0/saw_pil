@extends('admin.layouts.master')

@section('title', 'Rekapitulasi Tahunan')

@section('content')
    <h2 class="text-3xl font-semibold mb-8 text-gray-800 flex items-center gap-2">
        <i class="fas fa-calendar-alt text-blue-600"></i>
        Rekapitulasi Tahunan
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($years as $year)
            <a href="{{ route('admin.rekap.show', $year) }}"
                class="transition duration-200 hover:scale-[1.02] hover:shadow-lg border border-gray-200 bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full mb-4">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">{{ $year }}</span>
                <span class="text-sm text-gray-500 mt-1">Lihat Rekap</span>
            </a>
        @empty
            <div class="col-span-full text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-yellow-500 text-lg mr-2"></i>
                Belum ada data rekap tersedia.
            </div>
        @endforelse
    </div>
@endsection
