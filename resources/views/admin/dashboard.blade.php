@extends('admin.layouts.master')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Card Peserta -->
        <div
            class="group p-6 rounded-2xl shadow-lg transform transition duration-500 bg-gradient-to-r from-blue-400 to-blue-600 text-white flex items-center hover:shadow-2xl hover:scale-105">
            <div
                class="p-4 bg-white bg-opacity-20 rounded-full transition-transform duration-300 group-hover:animate-bounce">
                <i class="bi bi-people-fill text-3xl"></i>
            </div>
            <div class="ml-4">
                <h5 class="text-sm font-medium uppercase">Peserta</h5>
                <h2 class="text-2xl font-bold mt-1">{{ $totalPeserta }}</h2>
            </div>
        </div>

        <!-- Card Total Berkas -->
        <div
            class="group p-6 rounded-2xl shadow-lg transform transition duration-500 bg-gradient-to-r from-green-400 to-green-600 text-white flex items-center hover:shadow-2xl hover:scale-105">
            <div class="p-4 bg-white bg-opacity-20 rounded-full transition-transform duration-300 group-hover:animate-pulse">
                <i class="bi bi-file-earmark-fill text-3xl"></i>
            </div>
            <div class="ml-4">
                <h5 class="text-sm font-medium uppercase">Total Berkas</h5>
                <h2 class="text-2xl font-bold mt-1">{{ $totalBerkas }}</h2>
                <span class="text-xs opacity-75">Pending: {{ $pendingBerkas }}</span>
            </div>
        </div>

        <!-- Card Pemenang -->
        <div
            class="group p-6 rounded-2xl shadow-lg transform transition duration-500 bg-gradient-to-r from-purple-400 to-purple-600 text-white hover:shadow-2xl hover:scale-105">
            <h5 class="text-sm font-medium uppercase mb-4">Pemenang Teratas</h5>
            <div class="space-y-3">
                @foreach ($winners as $index => $win)
                    <div class="flex items-center transition-transform duration-300 group-hover:translate-x-2">
                        <span class="w-6">#{{ $index + 1 }}</span>
                        <div class="ml-3">
                            <p class="text-sm font-semibold">{{ $win->peserta->user->name }}</p>
                            <p class="text-xs opacity-75">Skor: {{ number_format($win->total_akhir, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tabel Berkas Terbaru -->
    <div class="bg-white p-6 mt-8 rounded-2xl shadow-lg">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Berkas Terbaru</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($latestSubmissions as $i => $sub)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $sub->peserta->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 truncate" style="max-width: 180px;">
                                {{ $sub->file_path }}
                            </td>
                            <td class="px-4 py-3 text-sm text-center">
                                @php
                                    $colors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $colors[$sub->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('admin.dashboard.destroySubmission', $sub->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus berkas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
