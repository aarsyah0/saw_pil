@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto py-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold">Manajemen Jadwal PI/BI</h1>
            <button onclick="openFormModal('create')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Jadwal Baru
            </button>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Peserta</th>
                        <th class="px-6 py-3 text-left">Juri</th>
                        <th class="px-6 py-3 text-center">Tanggal</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($schedules as $i => $s)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $schedules->firstItem() + $i }}</td>
                            <td class="px-6 py-4">{{ $s->peserta->name }}</td>
                            <td class="px-6 py-4">{{ $s->juris->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4 text-center">{{ $s->tanggal->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">{{ $s->lokasi }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="openDetailModal({{ $s->id }})"
                                    class="px-2 py-1 border border-green-600 text-green-600 rounded hover:bg-green-50">
                                    Detail
                                </button>
                                <button onclick="openFormModal('edit',{{ $s->id }})"
                                    class="px-2 py-1 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50">
                                    Edit
                                </button>
                                <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin?')">
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

    {{-- Create/Edit Modal --}}
    <div id="formModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 id="modalTitle" class="text-lg font-semibold"></h2>
                <button onclick="closeFormModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <div id="formContent" class="p-6"></div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Detail Jadwal</h2>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <div id="detailContent" class="p-6 max-h-[60vh] overflow-y-auto"></div>
        </div>
    </div>

    <script>
        function openFormModal(mode, id = null) {
            const url = mode === 'create' ?
                "{{ route('admin.schedules.create') }}" :
                `/admin/schedules/${id}/edit`;

            document.getElementById('modalTitle').textContent = mode === 'create' ?
                'Buat Jadwal Baru' :
                'Edit Jadwal';

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.text())
                .then(html => {
                    document.getElementById('formContent').innerHTML = html;
                    document.getElementById('formModal').classList.replace('hidden', 'flex');
                });
        }

        function closeFormModal() {
            document.getElementById('formModal').classList.replace('flex', 'hidden');
        }

        function openDetailModal(id) {
            const url = `{{ route('admin.schedules.detail', ['schedule' => '__ID__']) }}`.replace('__ID__', id);
            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.text())
                .then(html => {
                    document.getElementById('detailContent').innerHTML = html;
                    document.getElementById('detailModal').classList.replace('hidden', 'flex');
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.replace('flex', 'hidden');
        }
    </script>
@endsection
