{{-- resources/views/user/berkas/index.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Daftar Berkas CU')
@section('page_title', 'Berkas CU Saya')

@section('content')
    <div x-data="{ showModal: false }" x-cloak class="relative">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Submission CU</h2>
            <button @click="showModal = true"
                class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                <i class="bi bi-upload text-lg"></i>
                <span>Unggah Berkas CU</span>
            </button>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No</th>
                            <th
                                class="w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th
                                class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Unggah</th>
                            <th
                                class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Skor</th>
                            <th
                                class="w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Komentar</th>
                            <th
                                class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($submissions as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="font-medium">{{ optional($item->kategori)->wujud_cu ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">Level {{ optional($item->kategori)->level_id ?? '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->submitted_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($item->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ number_format($item->skor, 2) }}</td>
                                <td class="px-6 py-4 whitespace-pre-wrap text-sm text-gray-700">
                                    @if ($item->status === 'rejected')
                                        {!! nl2br(e($item->comment)) !!}
                                    @else
                                        &mdash;
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                        class="underline text-blue-600">Unduh</a>
                                    <form action="{{ route('berkas.destroy', $item->id) }}" method="POST"
                                        class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada
                                    submission.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Unggah Berkas -->
        <div x-show="showModal"
            class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center p-4 z-50"
            x-transition.opacity>
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6" x-transition.scale>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Unggah Berkas CU</h3>
                    <button @click="showModal = false" class="text-gray-600 hover:text-gray-800">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>
                <form action="{{ route('berkas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="kategori_cu_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori CU</label>
                        <select name="kategori_cu_id" id="kategori_cu_id"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kategori_cu_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->wujud_cu }} (Lv {{ $k->level_id }}) – Skor {{ number_format($k->skor, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_cu_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File (PDF/ZIP, max
                            10MB)</label>
                        <input type="file" name="file" id="file" accept=".pdf,.zip"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="showModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Batal</button>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
