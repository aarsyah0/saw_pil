@extends('juri.layouts.master')

@section('title', 'Daftar Penilaian')

@section('content')
    <div x-data="penilaian()" class="space-y-6">

        {{-- Header --}}
        <div class="bg-[#E7EFF6] p-6 rounded-3xl shadow-lg flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-gray-900">Daftar Penilaian</h1>
            <span class="text-gray-700">Total Jadwal: <strong>{{ $schedules->count() }}</strong></span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Nama Mahasiswa</th>
                        <th class="px-4 py-3 font-semibold text-center">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-center">Lokasi</th>
                        <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($schedules as $i => $s)
                        @php
                            $penilaianAkhir = $s->peserta->penilaianAkhir;
                            $piDone = $penilaianAkhir && $penilaianAkhir->skor_pi_normal !== null;
                            $biDone = $penilaianAkhir && $penilaianAkhir->skor_bi_normal !== null;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">{{ $s->peserta->name }}</td>
                            <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-center">{{ $s->lokasi }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 justify-center">
                                    <button
                                        @click="open('pi', {{ $s->id }}, '{{ $s->peserta->name }}', {{ $piDone ? 'true' : 'false' }})"
                                        class="px-3 py-1 rounded text-white {{ $piDone ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}"
                                        {{ $piDone ? 'disabled' : '' }}>
                                        Nilai PI
                                    </button>

                                    <button
                                        @click="open('bi', {{ $s->id }}, '{{ $s->peserta->name }}', {{ $biDone ? 'true' : 'false' }})"
                                        class="px-3 py-1 rounded text-white {{ $biDone ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }}"
                                        {{ $biDone ? 'disabled' : '' }}>
                                        Nilai BI
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Modal --}}
        <div x-show="show" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
                <button @click="close()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>

                {{-- Modal Header --}}
                <h2 class="text-2xl font-semibold mb-4" x-text="title"></h2>

                {{-- If already rated --}}
                <template x-if="hasRated">
                    <div class="p-4 bg-yellow-100 rounded">
                        <p class="text-yellow-800">Anda sudah melakukan penilaian ini.</p>
                    </div>
                </template>

                {{-- Form --}}
                <form x-show="!hasRated" :action="action" method="POST" class="space-y-4">
                    @csrf

                    {{-- PI Fields --}}
                    <div x-show="type==='pi'">
                        @foreach ([
            'penyajian' => ['label' => 'Penyajian', 'max' => 15],
            'substansi_masalah' => ['label' => 'Substansi Masalah', 'max' => 20],
            'substansi_solusi' => ['label' => 'Substansi Solusi', 'max' => 35],
            'kualitas_pi' => ['label' => 'Kualitas PI', 'max' => 30],
        ] as $field => $opt)
                            <div class="flex items-center gap-4">
                                <label class="flex-1 text-gray-700">{{ $opt['label'] }} (0-{{ $opt['max'] }})</label>
                                <input type="number" name="{{ $field }}" min="0" max="{{ $opt['max'] }}"
                                    value="0" class="w-20 px-2 py-1 border rounded text-center" required>
                            </div>
                        @endforeach
                    </div>

                    {{-- BI Fields --}}
                    <div x-show="type==='bi'">
                        @foreach ([
            'content_score' => ['label' => 'Content', 'max' => 25],
            'accuracy_score' => ['label' => 'Accuracy', 'max' => 25],
            'fluency_score' => ['label' => 'Fluency', 'max' => 20],
            'pronunciation_score' => ['label' => 'Pronunciation', 'max' => 20],
            'overall_perf_score' => ['label' => 'Overall Performance', 'max' => 10],
        ] as $field => $opt)
                            <div class="flex items-center gap-4">
                                <label class="flex-1 text-gray-700">{{ $opt['label'] }} (0-{{ $opt['max'] }})</label>
                                <input type="number" name="{{ $field }}" min="0" max="{{ $opt['max'] }}"
                                    value="0" class="w-20 px-2 py-1 border rounded text-center" required>
                            </div>
                        @endforeach
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                            :class="type === 'pi' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700'"
                            class="text-white px-6 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine.js --}}
    <script>
        function penilaian() {
            return {
                show: false,
                type: null,
                title: '',
                action: '',
                hasRated: false, // flag jika sudah menilai
                open(type, id, name, rated) {
                    this.type = type;
                    this.title = (type === 'pi' ? 'Penilaian PI' : 'Penilaian BI') + ' – ' + name;
                    this.action = `/juri/penilaian/${type}/${id}`;
                    this.hasRated = rated; // set flag
                    this.show = true;
                },
                close() {
                    this.show = false;
                }
            }
        }
    </script>
@endsection
