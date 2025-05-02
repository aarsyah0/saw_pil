@extends('admin.layouts.master')

@section('title', 'Kelola Bidang CU')

@section('content')
    <div x-data="bidangCu()" class="relative">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Bidang Capaian Unggulan</h1>
            <button @click="openCreate()" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-1"></i> Tambah Bidang
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
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Nama Bidang</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bidangs as $idx => $bidang)
                        <tr>
                            <td class="px-6 py-4">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4">{{ $bidang->nama }}</td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openEdit({{ $bidang->id }}, '{{ addslashes($bidang->nama) }}')"
                                    class="px-3 py-1 mr-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('admin.bidang-cu.destroy', $bidang->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($bidangs->isEmpty())
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data bidang.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Modal Overlay --}}
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="closeModal()" class="bg-white rounded-lg shadow-lg w-96 p-6" x-cloak>
                <h2 class="text-xl font-semibold mb-4" x-text="modalTitle"></h2>
                <form :action="modalUrl" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 mb-1">Nama Bidang</label>
                        <input type="text" id="nama" name="nama" x-model="form.nama"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none" required>
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

    @push('scripts')
        <script>
            function bidangCu() {
                return {
                    showModal: false,
                    isEdit: false,
                    modalTitle: '',
                    modalUrl: '',
                    form: {
                        nama: ''
                    },

                    openCreate() {
                        this.isEdit = false;
                        this.modalTitle = 'Tambah Bidang CU';
                        this.modalUrl = '{{ route('admin.bidang-cu.store') }}';
                        this.form.nama = '';
                        this.showModal = true;
                    },

                    openEdit(id, nama) {
                        this.isEdit = true;
                        this.modalTitle = 'Edit Bidang CU';
                        this.modalUrl = '/admin/bidang-cu/' + id; // sesuai route update
                        this.form.nama = nama;
                        this.showModal = true;
                    },

                    closeModal() {
                        this.showModal = false;
                    }
                }
            }
        </script>
    @endpush
@endsection
