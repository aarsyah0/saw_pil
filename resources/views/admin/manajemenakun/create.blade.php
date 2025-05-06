@extends('admin.layouts.master')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Akun Baru</h1>
    <form action="{{ route('admin.manajemen-akun.store') }}" method="POST">
        @include('admin.manajemenakun._form', ['submitText' => 'Simpan'])
    </form>
@endsection
