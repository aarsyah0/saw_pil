{{-- resources/views/user/profile-form.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Profile Saya')
@section('page_title', 'Profile Saya')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg space-y-8">
        {{-- Sukses & Error Messages --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Langkah 1: Unggah / Ganti Foto & Surat --}}
        <section class="space-y-6">
            <h2 class="text-2xl font-semibold border-b pb-2">Langkah 1: Unggah / Ganti Foto & Surat Pengantar</h2>
            <form action="{{ route('user.profile.uploadFiles') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div class="flex flex-col md:flex-row md:space-x-8 items-center">
                    {{-- Preview Foto --}}
                    <div class="flex-shrink-0 mb-4 md:mb-0">
                        @if ($profile->pas_foto)
                            <img src="{{ asset('storage/' . $profile->pas_foto) }}" alt="Foto Profil"
                                class="w-40 h-40 object-cover rounded-full border-4 border-white shadow-lg">
                        @else
                            <div class="w-40 h-40 flex items-center justify-center bg-gray-100 rounded-full">
                                <span class="text-gray-400">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    {{-- Input Foto --}}
                    <div class="w-full md:w-1/2 space-y-2">
                        <label for="pas_foto" class="block text-sm font-medium text-gray-700">
                            {{ $profile->pas_foto ? 'Ganti Foto Profil' : 'Unggah Foto Profil' }}
                        </label>
                        <input type="file" name="pas_foto" id="pas_foto" accept="image/*"
                            class="mt-1 w-full border rounded-lg p-2">
                        @error('pas_foto')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:space-x-8 items-center">
                    {{-- Preview Surat --}}
                    <div class="flex-shrink-0 mb-4 md:mb-0">
                        @if ($profile->surat_pengantar)
                            <a href="{{ asset('storage/' . $profile->surat_pengantar) }}" target="_blank"
                                class="inline-flex items-center space-x-2 bg-white border border-gray-300 p-4 rounded-lg shadow">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M6 2a2 2 0 00-2 2v16c0 1.1.9 2 2 2h12a2 2 0 002-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5z" />
                                </svg>
                                <span class="font-medium">Download Surat</span>
                            </a>
                        @else
                            <div class="w-48 h-32 flex items-center justify-center bg-gray-100 rounded-lg">
                                <span class="text-gray-400">Belum ada surat</span>
                            </div>
                        @endif
                    </div>

                    {{-- Input Surat --}}
                    <div class="w-full md:w-1/2 space-y-2">
                        <label for="surat_pengantar" class="block text-sm font-medium text-gray-700">
                            {{ $profile->surat_pengantar ? 'Ganti Surat Pengantar (PDF)' : 'Unggah Surat Pengantar (PDF)' }}
                        </label>
                        <input type="file" name="surat_pengantar" id="surat_pengantar" accept="application/pdf"
                            class="mt-1 w-full border rounded-lg p-2">
                        @error('surat_pengantar')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        {{ $profile->pas_foto || $profile->surat_pengantar ? 'Update File' : 'Unggah File' }}
                    </button>
                </div>
            </form>
        </section>

        {{-- Langkah 2: Lengkapi Data Profil --}}
        <section class="space-y-6">
            <h2 class="text-2xl font-semibold border-b pb-2">Langkah 2: Lengkapi Data Profil</h2>
            <form action="{{ route('user.profile.save') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama & Email --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password Baru <span class="text-gray-400 text-xs">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password" id="password" class="mt-1 w-full border rounded-lg p-2">
                        @error('password')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 w-full border rounded-lg p-2">
                    </div>

                    {{-- NIK & NIM --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" id="nik" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('nik', $profile->nik) }}">
                        @error('nik')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" name="nim" id="nim" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('nim', $profile->nim) }}">
                        @error('nim')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kontak & Lahir --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('no_hp', $profile->no_hp) }}">
                        @error('no_hp')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('tempat_lahir', $profile->tempat_lahir) }}">
                        @error('tempat_lahir')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('tanggal_lahir', optional($profile->tanggal_lahir)->format('Y-m-d')) }}">
                        @error('tanggal_lahir')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <label for="program_pendidikan" class="block text-sm font-medium text-gray-700">Program
                            Pendidikan</label>
                        <select name="program_pendidikan" id="program_pendidikan"
                            class="mt-1 w-full border rounded-lg p-2">
                            <option value="">-- Pilih --</option>
                            <option value="Diploma"
                                {{ old('program_pendidikan', $profile->program_pendidikan) == 'Diploma' ? 'selected' : '' }}>
                                Diploma</option>
                            <option value="Sarjana"
                                {{ old('program_pendidikan', $profile->program_pendidikan) == 'Sarjana' ? 'selected' : '' }}>
                                Sarjana</option>
                        </select>
                        @error('program_pendidikan')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <input type="text" name="program_studi" id="program_studi"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('program_studi', $profile->program_studi) }}">
                        @error('program_studi')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="semester_ke" class="block text-sm font-medium text-gray-700">Semester ke-</label>
                        <input type="number" name="semester_ke" id="semester_ke" min="1"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('semester_ke', $profile->semester_ke) }}">
                        @error('semester_ke')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="ipk" class="block text-sm font-medium text-gray-700">IPK</label>
                        <input type="number" step="0.01" max="4" name="ipk" id="ipk"
                            class="mt-1 w-full border rounded-lg p-2" value="{{ old('ipk', $profile->ipk) }}">
                        @error('ipk')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="kode_pt" class="block text-sm font-medium text-gray-700">Kode PT</label>
                        <input type="text" name="kode_pt" id="kode_pt" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('kode_pt', $profile->kode_pt) }}">
                        @error('kode_pt')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="wilayah_lldikti" class="block text-sm font-medium text-gray-700">Wilayah
                            LLDIKTI</label>
                        <input type="text" name="wilayah_lldikti" id="wilayah_lldikti"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('wilayah_lldikti', $profile->wilayah_lldikti) }}">
                        @error('wilayah_lldikti')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="perguruan_tinggi" class="block text-sm font-medium text-gray-700">Perguruan
                            Tinggi</label>
                        <input type="text" name="perguruan_tinggi" id="perguruan_tinggi"
                            class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('perguruan_tinggi', $profile->perguruan_tinggi) }}">
                        @error('perguruan_tinggi')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat_pt" class="block text-sm font-medium text-gray-700">Alamat Perguruan
                            Tinggi</label>
                        <textarea name="alamat_pt" id="alamat_pt" rows="3" class="mt-1 w-full border rounded-lg p-2">{{ old('alamat_pt', $profile->alamat_pt) }}</textarea>
                        @error('alamat_pt')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telp_pt" class="block text-sm font-medium text-gray-700">Telp. Perguruan
                            Tinggi</label>
                        <input type="text" name="telp_pt" id="telp_pt" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('telp_pt', $profile->telp_pt) }}">
                        @error('telp_pt')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email_pt" class="block text-sm font-medium text-gray-700">Email Perguruan
                            Tinggi</label>
                        <input type="email" name="email_pt" id="email_pt" class="mt-1 w-full border rounded-lg p-2"
                            value="{{ old('email_pt', $profile->email_pt) }}">
                        @error('email_pt')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Simpan Data Profil
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
