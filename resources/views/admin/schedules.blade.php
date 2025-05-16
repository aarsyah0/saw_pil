@extends('admin.layouts.master')

@section('content')
    <div class="w-full px-8 py-8">
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold">Manajemen Jadwal PI/BI</h1>
            <button id="btnOpenModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Jadwal Baru
            </button>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Peserta</th>
                        <th class="px-6 py-3 text-left">Juri</th>
                        <th class="px-6 py-3 text-center">Tanggal & Waktu</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($schedules as $i => $s)
                        <tr class="hover:bg-gray-50" data-id="{{ $s->id }}" data-peserta="{{ $s->peserta->id }}"
                            data-juries="{{ $s->juris->pluck('id')->join(',') }}"
                            data-tanggal="{{ $s->tanggal->format('Y-m-d\\TH:i') }}" data-lokasi="{{ $s->lokasi }}">
                            <td class="px-6 py-4">{{ $schedules->firstItem() + $i }}</td>
                            <td class="px-6 py-4">{{ $s->peserta->name }}</td>
                            <td class="px-6 py-4">{{ $s->juris->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4 text-center">{{ $s->tanggal->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $s->lokasi }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button
                                    class="btnDetail px-2 py-1 border border-green-600 text-green-600 rounded hover:bg-green-50">
                                    Detail
                                </button>
                                <button
                                    class="btnEdit px-2 py-1 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50">
                                    Edit
                                </button>
                                <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 border border-red-600 text-red-600 rounded hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $schedules->links() }}</div>
        </div>
    </div>

    <!-- Unified Modal for Create/Edit/Detail -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 id="modalTitle" class="text-lg font-semibold"></h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form id="modalForm" class="p-6 max-h-[70vh] overflow-y-auto" method="POST">
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST">

                <div class="mb-4">
                    <label class="block mb-1">Peserta</label>
                    <select id="peserta_id" name="peserta_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Peserta --</option>
                        @foreach ($pesertas as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Juri</label>
                    <select id="juri_id" name="juri_id[]" multiple class="w-full border rounded px-3 py-2 h-32">
                        @foreach ($juris as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Tanggal & Waktu</label>
                    <input id="tanggal" type="datetime-local" name="tanggal" class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">Lokasi</label>
                    <input id="lokasi" type="text" name="lokasi" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="text-right">
                    <button type="submit" id="btnSubmit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('modal');
        const form = document.getElementById('modalForm');
        const methodInput = document.getElementById('_method');
        const titleEl = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('btnSubmit');

        // Open modal for create
        document.getElementById('btnOpenModal').addEventListener('click', () => openModal('create'));

        // Delegate edit/detail buttons
        document.querySelector('tbody').addEventListener('click', e => {
            const tr = e.target.closest('tr');
            if (!tr) return;

            const data = {
                id: tr.dataset.id,
                peserta_id: tr.dataset.peserta,
                juri_ids: tr.dataset.juries.split(','),
                tanggal: tr.dataset.tanggal,
                lokasi: tr.dataset.lokasi
            };

            if (e.target.classList.contains('btnEdit')) openModal('edit', data);
            if (e.target.classList.contains('btnDetail')) openModal('detail', data);
        });

        function openModal(mode, data = {}) {
            modal.classList.replace('hidden', 'flex');
            form.reset();
            // enable all fields
            ['peserta_id', 'tanggal', 'lokasi'].forEach(id => document.getElementById(id).disabled = false);
            Array.from(document.getElementById('juri_id').options).forEach(opt => opt.disabled = false);

            if (mode === 'create') {
                titleEl.textContent = 'Buat Jadwal Baru';
                form.action = `{{ route('admin.schedules.store') }}`;
                methodInput.value = 'POST';
                submitBtn.style.display = '';
            }

            if (mode === 'edit') {
                titleEl.textContent = 'Edit Jadwal';
                form.action = `/admin/schedules/${data.id}`;
                methodInput.value = 'PUT';
                document.getElementById('peserta_id').value = data.peserta_id;
                document.getElementById('tanggal').value = data.tanggal;
                document.getElementById('lokasi').value = data.lokasi;
                Array.from(document.getElementById('juri_id').options)
                    .forEach(opt => opt.selected = data.juri_ids.includes(opt.value));
                submitBtn.style.display = '';
            }

            if (mode === 'detail') {
                titleEl.textContent = 'Detail Jadwal';
                submitBtn.style.display = 'none';
                ['peserta_id', 'tanggal', 'lokasi'].forEach(id => {
                    const el = document.getElementById(id);
                    el.value = data[id];
                    el.disabled = true;
                });
                Array.from(document.getElementById('juri_id').options).forEach(opt => {
                    opt.selected = data.juri_ids.includes(opt.value);
                    opt.disabled = true;
                });
            }
        }

        function closeModal() {
            modal.classList.replace('flex', 'hidden');
        }
    </script>
@endpush
