@extends('admin.layouts.master')

@section('title', 'Kelola Kategori CU')

@section('content')
    <div x-data="kategoriCu()" class="relative">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Kategori Capaian Unggulan</h1>
            <button @click="openCreate()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-1"></i> Tambah Kategori
            </button>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Bidang</th>
                        <th class="px-6 py-3">Wujud CU</th>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Level</th>
                        <th class="px-6 py-3 text-right">Skor</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoris as $i => $kat)
                        <tr>
                            <td class="px-6 py-4">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">{{ $kat->bidang->nama }}</td>
                            <td class="px-6 py-4">{{ $kat->wujud_cu }}</td>
                            <td class="px-6 py-4">{{ $kat->kode }}</td>
                            <td class="px-6 py-4">{{ $kat->level->level }}</td>
                            <td class="px-6 py-4 text-right">{{ $kat->skor }}</td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="openEdit({{ $kat->id }}, {{ $kat->bidang_id }}, '{{ addslashes($kat->wujud_cu) }}', '{{ $kat->kode }}', '{{ $kat->level_id }}', {{ $kat->skor }})"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('admin.kategori-cu.destroy', $kat->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Hapus kategori?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($kategoris->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Modal --}}
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="closeModal()" class="bg-white rounded-lg shadow-lg w-96 p-6" x-cloak>
                <h2 class="text-xl font-semibold mb-4" x-text="modalTitle"></h2>
                <form :action="modalUrl" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="mb-3">
                        <label class="block mb-1">Bidang CU</label>
                        <select name="bidang_id" x-model="form.bidang_id" class="w-full border rounded px-2 py-1">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($bidangs as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Wujud CU</label>
                        <input type="text" name="wujud_cu" x-model="form.wujud_cu"
                            class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Kode</label>
                        <input type="text" name="kode" x-model="form.kode" class="w-full border rounded px-2 py-1"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Level CU</label>
                        <select name="level_id" x-model="form.level_id" class="w-full border rounded px-2 py-1">
                            <option value="">-- Pilih Level --</option>
                            @foreach ($levels as $l)
                                <option value="{{ $l->level }}">{{ $l->level }} - {{ $l->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Skor</label>
                        <input type="number" name="skor" x-model="form.skor" step="0.01"
                            class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 mr-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            x-text="isEdit ? 'Update' : 'Simpan'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function kategoriCu() {
            return {
                showModal: false,
                isEdit: false,
                modalTitle: '',
                modalUrl: '',
                form: {
                    bidang_id: '',
                    wujud_cu: '',
                    kode: '',
                    level_id: '',
                    skor: 0
                },

                openCreate() {
                    this.isEdit = false;
                    this.modalTitle = 'Tambah Kategori CU';
                    this.modalUrl = '{{ route('admin.kategori-cu.store') }}';
                    this.form = {
                        bidang_id: '',
                        wujud_cu: '',
                        kode: '',
                        level_id: '',
                        skor: 0
                    };
                    this.showModal = true;
                },

                openEdit(id, bidang_id, wujud_cu, kode, level_id, skor) {
                    this.isEdit = true;
                    this.modalTitle = 'Edit Kategori CU';
                    this.modalUrl = '/admin/kategori-cu/' + id;
                    this.form = {
                        bidang_id,
                        wujud_cu,
                        kode,
                        level_id,
                        skor
                    };
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                }
            }
        }
    </script>
@endpush
