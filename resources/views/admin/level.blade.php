{{-- resources/views/admin/level_cu/index.blade.php --}}
@extends('admin.layouts.master')

@section('title', 'Kelola Level CU')

@section('content')
    <div x-data="levelCu()" class="relative">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Level Capaian Unggulan</h1>
            <button @click="openCreate()" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-1"></i> Tambah Level
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
                        <th class="px-6 py-3 text-left">Kode Level</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $idx => $level)
                        <tr>
                            <td class="px-6 py-4">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4">{{ $level->level }}</td>
                            <td class="px-6 py-4">{{ $level->description }}</td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openEdit('{{ $level->level }}', '{{ addslashes($level->description) }}')"
                                    class="px-3 py-1 mr-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('admin.level-cu.destroy', $level->level) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin menghapus level ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($levels->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data level.
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
                    <div class="mb-4">
                        <label for="level" class="block text-gray-700 mb-1">Kode Level</label>
                        <input type="text" id="level" name="level" x-model="form.level"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                            x-bind:readonly="isEdit" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" id="description" name="description" x-model="form.description"
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
            function levelCu() {
                return {
                    showModal: false,
                    isEdit: false,
                    modalTitle: '',
                    modalUrl: '',
                    form: {
                        level: '',
                        description: ''
                    },

                    openCreate() {
                        this.isEdit = false;
                        this.modalTitle = 'Tambah Level CU';
                        this.modalUrl = '{{ route('admin.level-cu.store') }}';
                        this.form.level = '';
                        this.form.description = '';
                        this.showModal = true;
                    },

                    openEdit(level, description) {
                        this.isEdit = true;
                        this.modalTitle = 'Edit Level CU';
                        this.modalUrl = '/admin/level-cu/' + level;
                        this.form.level = level;
                        this.form.description = description;
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
