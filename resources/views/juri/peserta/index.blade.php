@extends('juri.layouts.master')

@section('title', 'Daftar Peserta')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Daftar Peserta</h2>

        {{-- Search Bar --}}
        <div class="mb-4 flex justify-between items-center">
            <div class="relative w-full max-w-sm">
                <input type="text" id="search" name="search" placeholder="Cari peserta..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onkeyup="filterTable()" />
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            {{-- Pagination placeholder --}}
            {{-- <div>{{ $peserta->links() }}</div> --}}
        </div>

        @if ($peserta->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <p class="text-yellow-700">Belum ada peserta terdaftar.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NIM
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Program Studi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Semester</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Detail</th>
                        </tr>
                    </thead>
                    <tbody id="peserta-table" class="bg-white divide-y divide-gray-200">
                        @foreach ($peserta as $i => $p)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $p->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->nim }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->program_studi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->semester_ke }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('juri.peserta.show', $p->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function filterTable() {
                const input = document.getElementById('search');
                const filter = input.value.toLowerCase();
                const rows = document.querySelectorAll('#peserta-table tr');
                rows.forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    let text = '';
                    for (let i = 0; i < cells.length - 1; i++) {
                        text += cells[i].textContent.toLowerCase() + ' ';
                    }
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            }
        </script>
    @endpush
@endsection
