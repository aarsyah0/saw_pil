@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Ringkasan Capaian Unggulan (CU)</h1>

        <div class="overflow-x-auto bg-white shadow rounded mb-8">
            <table class="min-w-full table-fixed text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-3 text-left">#</th>
                        <th class="px-2 py-3 text-left">Peserta</th>
                        <th class="px-2 py-3 text-center">Kompetisi</th>
                        <th class="px-2 py-3 text-center">Pengakuan</th>
                        <th class="px-2 py-3 text-center">Penghargaan</th>
                        <th class="px-2 py-3 text-center">Karir Organisasi</th>
                        <th class="px-2 py-3 text-center">Hasil Karya</th>
                        <th class="px-2 py-3 text-center">PAK</th>
                        <th class="px-2 py-3 text-center">Kewirausahaan</th>
                        <th class="px-2 py-3 text-center">Total Mentah</th>
                        <th class="px-2 py-3 text-center">Normalisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $i => $r)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-2 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="px-2 py-2">{{ $r->name }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Kompetisi }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Pengakuan }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Penghargaan }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Karir_Organisasi }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Hasil_Karya }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->PAK }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->Kewirausahaan }}</td>
                            <td class="px-2 py-2 text-center">{{ $r->total_mentah }}</td>
                            <td class="px-2 py-2 text-center">{{ number_format($r->normalized, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100">
                        <td colspan="9" class="px-2 py-2 text-right font-semibold">MAX Total Mentah:</td>
                        <td class="px-2 py-2 text-center">{{ collect($rows)->max('total_mentah') }}</td>
                        <td class="px-2 py-2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h1 class="text-2xl font-bold mb-6">Verifikasi Berkas CU</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full table-fixed text-sm">
                <colgroup>
                    <col style="width:5%" />
                    <col style="width:20%" />
                    <col style="width:25%" />
                    <col style="width:10%" />
                    <col style="width:10%" />
                    <col style="width:15%" />
                    <col style="width:15%" />
                </colgroup>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-3">#</th>
                        <th class="px-2 py-3">Peserta</th>
                        <th class="px-2 py-3">Kategori</th>
                        <th class="px-2 py-3 text-center">Skor</th>
                        <th class="px-2 py-3 text-center">Min Skor</th>
                        <th class="px-2 py-3">File</th>
                        <th class="px-2 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-2 py-2 truncate">{{ $submission->peserta->name }}</td>
                            <td class="px-2 py-2 truncate">{{ $submission->kategori->wujud_cu }}</td>
                            <td class="px-2 py-2 text-center">{{ $submission->skor }}</td>
                            <td class="px-2 py-2 text-center">{{ $submission->kategori->skor }}</td>
                            <td class="px-2 py-2">
                                @if ($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                                        class="block truncate underline hover:text-blue-800">
                                        {{ Str::limit(basename($submission->file_path), 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-500 italic">—</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 text-center space-x-1">
                                <form action="{{ route('admin.verification.approve', $submission) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-2 py-1 text-xs rounded bg-green-500 hover:bg-green-600 text-white"
                                        {{ $submission->file_path ? '' : 'disabled' }}>
                                        Setuju
                                    </button>
                                </form>
                                <button type="button"
                                    data-reject-url="{{ route('admin.verification.reject', $submission->id) }}"
                                    onclick="openRejectModal(this)"
                                    class="px-2 py-1 text-xs rounded bg-red-500 hover:bg-red-600 text-white"
                                    {{ $submission->file_path ? '' : 'disabled' }}>
                                    Tolak
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-600">Belum ada submission.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal Reject --}}
        <div id="reject-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-semibold mb-4">Tolak Submission</h2>
                <form method="POST" id="reject-form" action="">
                    @csrf
                    <textarea name="comment" required class="w-full border rounded p-2 mb-4" placeholder="Berikan alasan penolakan"></textarea>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Kirim</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openRejectModal(button) {
            const url = button.getAttribute('data-reject-url');
            const modal = document.getElementById('reject-modal');
            const form = modal.querySelector('form');
            form.action = url;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
        }
    </script>
@endpush
