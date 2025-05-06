<!-- resources/views/admin/bobot.blade.php -->
@extends('admin.layouts.master')

@section('content')
    <div x-data="modalData()" x-init="init()">
        <!-- Header & Tambah -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen Bobot Kriteria</h2>
            <button @click="openCreate()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i>Tambah Bobot
            </button>
        </div>

        <!-- Alert Success -->
        <template x-if="sessionSuccess">
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg flex justify-between items-center">
                <span x-text="sessionSuccess"></span>
                <button @click="sessionSuccess=''; closeAlert()" class="text-green-800">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </template>

        <!-- Tabel Bobot -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Kriteria</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bobot</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_kriteria }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ number_format($item->bobot, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <button @click="openEdit($event)" data-nama="{{ $item->nama_kriteria }}"
                                    data-bobot="{{ $item->bobot }}"
                                    data-action="{{ route('admin.bobot-kriteria.update', $item->nama_kriteria) }}"
                                    class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    <i class="bi bi-pencil-fill mr-1"></i>Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data bobot.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah/Edit -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4" @click.away="closeModal()">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold" x-text="modalTitle"></h3>
                </div>
                <form :action="formAction" method="POST" class="px-6 py-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="mb-4" x-show="!isEdit">
                        <label for="nama_kriteria" class="block text-sm font-medium text-gray-700 mb-1">Kriteria</label>
                        <select name="nama_kriteria" id="nama_kriteria"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            x-model="selectedKriteria" required>
                            <option value="" disabled>-- Pilih Kriteria --</option>
                            <option value="CU">CU</option>
                            <option value="PI">PI</option>
                            <option value="BI">BI</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="bobot" class="block text-sm font-medium text-gray-700 mb-1">Bobot (0–1)</label>
                        <input type="number" name="bobot" id="bobot" step="0.01" min="0" max="1"
                            x-model="bobotValue"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            x-text="submitText"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function modalData() {
            return {
                showModal: false,
                isEdit: false,
                modalTitle: '',
                submitText: '',
                formAction: '',
                selectedKriteria: '',
                bobotValue: '',
                sessionSuccess: '{{ session('success') }}',

                init() {
                    // jika redirect dengan session success, munculkan alert
                    if (this.sessionSuccess) {
                        setTimeout(() => this.sessionSuccess = '', 5000);
                    }
                },

                openCreate() {
                    this.showModal = true;
                    this.isEdit = false;
                    this.modalTitle = 'Tambah Bobot Kriteria';
                    this.submitText = 'Simpan';
                    this.formAction = '{{ route('admin.bobot-kriteria.store') }}';
                    this.selectedKriteria = '';
                    this.bobotValue = '';
                },

                openEdit(event) {
                    const btn = event.currentTarget;
                    this.showModal = true;
                    this.isEdit = true;
                    this.modalTitle = 'Edit Bobot Kriteria';
                    this.submitText = 'Update';
                    this.formAction = btn.dataset.action;
                    this.selectedKriteria = btn.dataset.nama;
                    this.bobotValue = btn.dataset.bobot;
                },

                closeModal() {
                    this.showModal = false;
                },

                closeAlert() {
                    this.sessionSuccess = '';
                }
            }
        }
    </script>
@endpush
