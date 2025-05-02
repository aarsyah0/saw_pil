@extends('admin.layouts.master')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

    <div class="flex justify-center gap-16 mt-8">
        <!-- Card Pengguna -->
        <div class="bg-gray-100 p-5 rounded-3xl shadow-md flex items-center w-60 h-36">
            <div class="flex-shrink-0 mr-3">
                <i class="bi bi-people-fill text-5xl text-gray-700"></i>
            </div>
            <div class="flex flex-col pl-10">
                <h5 class="text-lg font-semibold text-gray-600">Peserta</h5>
                <h2 class="text-3xl font-bold text-gray-800 mt-4">10</h2>
            </div>
        </div>

        <!-- Card Berkas -->
        <div class="bg-gray-100 p-5 rounded-3xl shadow-md flex items-center w-60 h-36">
            <div class="flex-shrink-0 mr-3">
                <i class="bi bi-file-earmark-fill text-5xl text-gray-700"></i>
            </div>
            <div class="flex flex-col pl-10">
                <h5 class="text-lg font-semibold text-gray-600">Berkas</h5>
                <h2 class="text-3xl font-bold text-gray-800 mt-4">7</h2>
            </div>
        </div>
    </div>

    <!-- Card 3: Tabel Berkas -->
    <div class="bg-white p-8 mt-8 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold mb-4">Berkas Terbaru</h4>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left whitespace-normal">No</th>
                    <th class="border p-2 text-left whitespace-normal">Nama Mahasiswa</th>
                    <th class="border p-2 text-left whitespace-normal">Nama Berkas</th>
                    <th class="border p-2 text-left whitespace-normal">Nama Bidang</th>
                    <th class="border p-2 text-left whitespace-normal">Nama Wujud</th>
                    <th class="border p-2 text-left whitespace-normal">Kategori</th>
                    <th class="border p-2 text-center whitespace-normal">Jenis</th>
                    <th class="border p-2 text-center whitespace-normal">Status</th>
                    <th class="border p-2 text-center whitespace-normal">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris statis 1 -->
                <tr class="bg-white hover:bg-gray-100 transition">
                    <td class="border p-2 text-sm">1</td>
                    <td class="border p-2 text-sm">Andi</td>
                    <td class="border p-2 text-sm whitespace-normal break-words">
                        <div class="flex items-start">
                            <span class="truncate" style="max-width: 200px;">
                                SertifikatLiterasiDigital.pdf
                            </span>
                            <a href="/berkas/1"
                                class="ml-2 flex-shrink-0 bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 text-xs">
                                Lihat Detail
                            </a>
                        </div>
                    </td>
                    <td class="border p-2 text-sm">Kompetisi</td>
                    <td class="border p-2 text-sm">Perorangan</td>
                    <td class="border p-2 text-sm">Internasional</td>
                    <td class="border p-2 text-center text-sm">CU</td>
                    <td class="border p-2 text-center text-sm text-yellow-500">Menunggu</td>
                    <td class="border p-2 text-center">
                        <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 justify-center">
                            <button
                                class="w-full sm:w-auto bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
                                Setujui
                            </button>
                            <button
                                class="w-full sm:w-auto bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                                Tolak
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Baris statis 2 -->
                <tr class="bg-gray-50 hover:bg-gray-100 transition">
                    <td class="border p-2 text-sm">2</td>
                    <td class="border p-2 text-sm">Budi</td>
                    <td class="border p-2 text-sm whitespace-normal break-words">
                        <div class="flex items-start">
                            <span class="truncate" style="max-width: 200px;">
                                SertifikatKepanitiaan.pdf
                            </span>
                            <a href="/berkas/2"
                                class="ml-2 flex-shrink-0 bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 text-xs">
                                Lihat Detail
                            </a>
                        </div>
                    </td>
                    <td class="border p-2 text-sm">Kompetisi</td>
                    <td class="border p-2 text-sm">Tim</td>
                    <td class="border p-2 text-sm">Nasional</td>
                    <td class="border p-2 text-center text-sm">CU</td>
                    <td class="border p-2 text-center text-sm text-red-500">Ditolak</td>
                    <td class="border p-2 text-center">
                        <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 justify-center">
                            <button
                                class="w-full sm:w-auto bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
                                Setujui
                            </button>
                            <button
                                class="w-full sm:w-auto bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                                Tolak
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
