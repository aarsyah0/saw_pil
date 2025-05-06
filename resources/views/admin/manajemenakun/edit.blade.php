@extends('admin.layouts.master')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Akun: {{ $user->name }}</h1>
    <form action="{{ route('admin.manajemen-akun.update', $user) }}" method="POST">
        @method('PUT')
        @include('admin.manajemenakun._form', ['submitText' => 'Perbarui'])
    </form>
@endsection
