@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto py-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-extrabold mb-6">Daftar CU Selection Round-1</h1>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-2/12 px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="w-2/12 px-6 py-3 text-center text-sm font-semibold text-gray-700">Total Skor</th>
                        <th class="w-2/12 px-6 py-3 text-center text-sm font-semibold text-gray-700">Rata-rata</th>
                        <th class="w-2/12 px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                        <th class="w-2/12 px-6 py-3 text-center text-sm font-semibold text-gray-700">Waktu</th>
                        <th class="w-2/12 px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($selections as $sel)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-800 text-left">{{ $sel->peserta->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">
                                {{ number_format($sel->total_skor_cu, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ number_format($sel->avg_skor_cu, 4) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-medium rounded-full
                     {{ $sel->status_lolos == 'lolos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($sel->status_lolos) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">
                                {{ \Carbon\Carbon::parse($sel->selected_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <!-- Detail Button -->
                                    <button
                                        class="inline-flex items-center px-3 py-1 border border-indigo-600 rounded-lg text-indigo-600 hover:bg-indigo-50 focus:outline-none"
                                        onclick="openDetailModal({{ $sel->peserta_id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A2 2 0 0122 9.618v4.764a2 2 0 01-2.447 1.894L15 14M4 6h5l1 3h7l1 3H4l1-3h7l1-3H4z" />
                                        </svg>
                                        Detail
                                    </button>

                                    <!-- Update Status Form -->
                                    <form action="{{ route('admin.cu_selection.update_status', $sel->peserta_id) }}"
                                        method="POST" class="inline-flex items-center space-x-2">
                                        @csrf @method('PATCH')
                                        <select name="status_lolos"
                                            class="block border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="lolos" {{ $sel->status_lolos == 'lolos' ? 'selected' : '' }}>Lolos
                                            </option>
                                            <option value="gagal" {{ $sel->status_lolos == 'gagal' ? 'selected' : '' }}>Gagal
                                            </option>
                                        </select>
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Backdrop --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-xl w-full mx-4 overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Detail Capaian Unggulan</h2>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                {{-- AJAX content --}}
            </div>
        </div>
    </div>

    <script>
        function openDetailModal(pesertaId) {
            fetch(`/admin/cu-selection/${pesertaId}/detail`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.text())
                .then(html => {
                    const modal = document.getElementById('detailModal');
                    document.getElementById('modalContent').innerHTML = html;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection
