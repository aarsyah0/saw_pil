@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Verifikasi Berkas CU</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full table-fixed text-sm">
                {{-- Definisikan lebar tiap kolom --}}
                <colgroup>
                    <col style="width:5%" /> {{-- # --}}
                    <col style="width:20%" /> {{-- Peserta --}}
                    <col style="width:25%" /> {{-- Kategori --}}
                    <col style="width:10%" /> {{-- Skor --}}
                    <col style="width:10%" /> {{-- Min Skor --}}
                    <col style="width:15%" /> {{-- File --}}
                    <col style="width:15%" /> {{-- Aksi --}}
                </colgroup>

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-3 text-left">#</th>
                        <th class="px-2 py-3 text-left">Peserta</th>
                        <th class="px-2 py-3 text-left">Kategori</th>
                        <th class="px-2 py-3 text-center">Skor</th>
                        <th class="px-2 py-3 text-center">Min Skor</th>
                        <th class="px-2 py-3 text-left">File</th>
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
                                @if ($submission->file_path)
                                    <form action="{{ route('admin.verification.approve', $submission) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 text-xs rounded bg-green-500 hover:bg-green-600 text-white">
                                            Setuju
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $submission->id }})"
                                        class="px-2 py-1 text-xs rounded bg-red-500 hover:bg-red-600 text-white">
                                        Tolak
                                    </button>
                                @else
                                    <button disabled class="px-2 py-1 text-xs rounded bg-gray-300 text-gray-600">
                                        Setuju
                                    </button>
                                    <button disabled class="px-2 py-1 text-xs rounded bg-gray-300 text-gray-600">
                                        Tolak
                                    </button>
                                @endif
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


    </div>

    {{-- Modal Reject --}}
    <div id="reject-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-xl font-semibold mb-4">Tolak Submission</h2>
            <form id="reject-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium mb-1">Komentar</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border border-gray-300 rounded p-2" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openRejectModal(id) {
                const modal = document.getElementById('reject-modal');
                const form = document.getElementById('reject-form');
                form.action = `/admin/cu-verifikasi/${id}/reject`;
                modal.classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('reject-modal').classList.add('hidden');
            }
        </script>
    @endpush
@endsection
