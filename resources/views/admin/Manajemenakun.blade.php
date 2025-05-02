{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.master')

@section('title', 'Manajemen Akun')
@section('page-title', 'Manajemen Akun')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Manajemen Akun</h2>
        <a href="#" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Tambah Akun</a>
    </div>

    <table class="w-full table-auto bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Role</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{-- Baris data statis --}}
            <tr>
                <td class="px-4 py-2">John Doe</td>
                <td class="px-4 py-2">john.doe@example.com</td>
                <td class="px-4 py-2">Admin</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Aktif</span>
                </td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-yellow-600 hover:underline">Reset</a>
                    <a href="#" class="text-indigo-600 hover:underline">Non-aktifkan</a>
                    <a href="#" class="text-red-600 hover:underline">Hapus</a>
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2">Jane Smith</td>
                <td class="px-4 py-2">jane.smith@example.com</td>
                <td class="px-4 py-2">Juri</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Non-aktif</span>
                </td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-yellow-600 hover:underline">Reset</a>
                    <a href="#" class="text-indigo-600 hover:underline">Aktifkan</a>
                    <a href="#" class="text-red-600 hover:underline">Hapus</a>
                </td>
            </tr>
            {{-- Tambah baris contoh lain sesuai kebutuhan --}}
        </tbody>
    </table>
@endsection
