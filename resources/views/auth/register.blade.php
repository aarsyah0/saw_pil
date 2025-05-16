<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Peserta Pilmapres</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center relative font-sans"
    style="background-image: url('{{ asset('images/polije.png') }}')">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative z-10 flex items-center justify-center py-12 px-4">
        <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-3xl shadow-xl w-full max-w-5xl p-10">
            <!-- Header -->
            <div class="flex items-center justify-between mb-10">
                <a href="{{ url('/') }}"
                    class="text-white hover:text-gray-200 p-2 bg-gray-800 bg-opacity-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <img src="{{ asset('images/pilmapres.png') }}" alt="Logo Pilmapres" class="h-14">
                <div class="w-6"></div>
            </div>

            <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Formulir Pendaftaran Pilmapres</h2>
            <!-- Success / Error Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc pl-6 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Form -->
            <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data"
                class="space-y-12">
                @csrf

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-8">
                        <!-- Data Pribadi -->
                        <div class="space-y-4 p-6 bg-gray-50 rounded-xl shadow-inner">
                            <h3 class="text-2xl font-semibold text-gray-800 flex items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 15c4.503 0 8.483 1.87 11.314 4.868M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>Data Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-gray-700 mb-1">Nama Lengkap</label>
                                    <input id="name" name="name" type="text" required
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                                    <input id="email" name="email" type="email" required
                                        value="{{ old('email') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                                </div>
                                <div>
                                    <label for="nik" class="block text-gray-700 mb-1">NIK</label>
                                    <input id="nik" name="nik" type="text" required
                                        value="{{ old('nik') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                                </div>
                                <div>
                                    <label for="nim" class="block text-gray-700 mb-1">NIM</label>
                                    <input id="nim" name="nim" type="text" required
                                        value="{{ old('nim') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                                </div>
                                <div>
                                    <label for="no_hp" class="block text-gray-700 mb-1">No. HP</label>
                                    <input id="no_hp" name="no_hp" type="text" required
                                        value="{{ old('no_hp') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="pas_foto" class="block text-gray-700 mb-1">Pas Foto</label>
                                    <input id="pas_foto" name="pas_foto" type="file" accept="image/*" required
                                        class="w-full" />
                                </div>
                            </div>
                        </div>

                        <!-- Akun & Keamanan -->
                        <div class="space-y-4 p-6 bg-gray-50 rounded-xl shadow-inner">
                            <h3 class="text-2xl font-semibold text-gray-800 flex items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0 .346-.083.674-.23.966M16.24 16.24A4.993 4.993 0 0112 20a4.992 4.992 0 01-4.24-2.34M8 12a4 4 0 118 0m-8 0v1m8-1v1" />
                                </svg>Akun & Keamanan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-gray-700 mb-1">Password</label>
                                    <input id="password" name="password" type="password" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400" />
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-gray-700 mb-1">Konfirmasi
                                        Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-8">
                        <!-- Data Lahir & Studi -->
                        <div class="space-y-4 p-6 bg-gray-50 rounded-xl shadow-inner">
                            <h3 class="text-2xl font-semibold text-gray-800 flex items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>Data Lahir & Studi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tempat_lahir" class="block text-gray-700 mb-1">Tempat Lahir</label>
                                    <input id="tempat_lahir" name="tempat_lahir" type="text" required
                                        value="{{ old('tempat_lahir') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                                <div>
                                    <label for="tanggal_lahir" class="block text-gray-700 mb-1">Tanggal Lahir</label>
                                    <input id="tanggal_lahir" name="tanggal_lahir" type="date" required
                                        value="{{ old('tanggal_lahir') }}"
                                        class="w-full px-4 py-2 border border-gray-300rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                                <div>
                                    <label for="program_pendidikan" class="block text-gray-700 mb-1">Program
                                        Pendidikan</label>
                                    <select id="program_pendidikan" name="program_pendidikan" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400">
                                        <option value="" disabled>Pilih Program</option>
                                        <option value="Diploma3"
                                            {{ old('program_pendidikan') == 'Diploma3' ? 'selected' : '' }}>
                                            Diploma 3</option>
                                        <option value="Diploma4"
                                            {{ old('program_pendidikan') == 'Diploma4' ? 'selected' : '' }}>
                                            Diploma 4</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jurusan" class="block text-gray-700 mb-1">Jurusan</label>
                                    <input id="jurusan" name="jurusan" type="text" required
                                        value="{{ old('jurusan') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                                <div>
                                    <label for="program_studi" class="block text-gray-700 mb-1">Program Studi</label>
                                    <input id="program_studi" name="program_studi" type="text" required
                                        value="{{ old('program_studi') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                                <div>
                                    <label for="semester_ke" class="block text-gray-700 mb-1">Semester Ke-</label>
                                    <input id="semester_ke" name="semester_ke" type="number" min="1"
                                        required value="{{ old('semester_ke') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                                <div>
                                    <label for="ipk" class="block text-gray-700 mb-1">IPK</label>
                                    <input id="ipk" name="ipk" type="number" step="0.01"
                                        min="0" max="4" required value="{{ old('ipk') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="surat_pengantar" class="block text-gray-700 mb-1">Surat Pengantar</label>
                                <input id="surat_pengantar" name="surat_pengantar" type="file"
                                    accept=".pdf,.doc,.docx" required class="w-full" />
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-blue-600 text-white rounded-lg font-medium shadow-sm hover:bg-blue-700 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Daftar Sekarang
                        </button>
            </form>
        </div>
    </div>
</body>

</html>
