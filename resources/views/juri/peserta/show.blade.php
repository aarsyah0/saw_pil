@extends('juri.layouts.master')

@section('title', 'Profile Peserta')

@section('content')
    <div class="container mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center space-x-6 mb-6">
                @if (isset($peserta->pas_foto) && $peserta->pas_foto)
                    <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/photos/' . $peserta->pas_foto) }}" alt="Foto {{ $peserta->name }}"
                            class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $peserta->name }}</h2>
                    <p class="text-gray-600">NIM: <span class="font-medium">{{ $peserta->nim }}</span></p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <div class="space-y-2">
                    <p><span class="font-semibold">Email:</span> {{ $peserta->email }}</p>
                    <p><span class="font-semibold">NIK:</span> {{ $peserta->nik }}</p>
                    <p><span class="font-semibold">Tempat, Tanggal Lahir:</span> {{ $peserta->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                    <p><span class="font-semibold">No. HP:</span> {{ $peserta->no_hp }}</p>
                    <p><span class="font-semibold">IPK:</span> {{ $peserta->ipk }}</p>
                </div>
                <div class="space-y-2">
                    <p><span class="font-semibold">Program Pendidikan:</span> {{ $peserta->program_pendidikan }}</p>
                    <p><span class="font-semibold">Program Studi:</span> {{ $peserta->program_studi }}</p>
                    <p><span class="font-semibold">Semester:</span> {{ $peserta->semester_ke }}</p>
                    <p><span class="font-semibold">Perguruan Tinggi:</span> {{ $peserta->perguruan_tinggi }}</p>
                    <p><span class="font-semibold">Email PT:</span> {{ $peserta->email_pt }}</p>
                </div>
            </div>
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Alamat PT</h3>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-700 whitespace-pre-line">
                    {{ $peserta->alamat_pt }}
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('juri.peserta.index') }}"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
