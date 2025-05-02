<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-white flex">
    <aside class="w-1/5 bg-[#E7EFF6] text-black p-5 border-r-2 border-gray-300 h-screen fixed overflow-y-auto">
        <div class="flex items-center justify-center mb-5">
            <img src="/images/pilmapres.png" alt="PILMAPRES" class="w-16">
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('berkas.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-folder-fill text-lg mr-3"></i> Berkas
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.profile') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-person-circle text-lg mr-3"></i> Profile
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('user.hasil') }}"
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow">
                        <i class="bi bi-bar-chart-line-fill text-lg mr-3"></i> Hasil
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.jadwal') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-calendar-check-fill text-lg mr-3"></i> Jadwal
                    </a>
                </li>
                <li class="mt-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center py-3 px-4 rounded-lg bg-red-500 text-white font-bold shadow hover:bg-red-600 transition">
                            <i class="bi bi-box-arrow-right text-lg mr-3"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto ml-[20%]">
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">HASIL</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center mb-4">HASIL SELEKSI</h2>
            <div class="bg-gray-100 p-6 rounded-lg">
                <p class="border-b py-2 font-semibold">Nama : <span class="font-normal">Yoshi Toranaga</span></p>
                <p class="border-b py-2 font-semibold">NIM : <span class="font-normal">E4200886175</span></p>
                <p class="py-2 font-semibold">Status : <span class="text-red-600 font-bold">Menunggu</span></p>
            </div>
            <div class="flex justify-center mt-4">
                <button id="openModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="bi bi-eye-fill mr-2"></i> Lihat Berkas
                </button>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-lg w-[700px] border-4 border-gray-300 relative">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-center mb-4">Seleksi Pilmapres</h2>
                <hr class="mb-4">
                <h3 class="font-bold text-lg mb-2">Data Peserta :</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-semibold">Scan kartu tanda mahasiswa</p>
                        <div class="border p-2 w-full bg-white flex items-center rounded-lg shadow-sm">
                            <i class="bi bi-cloud-arrow-down-fill text-gray-500 mr-2"></i>
                            <input type="file" class="w-full text-gray-600">
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Kartu hasil studi (kumulatif)</p>
                        <div class="border p-2 w-full bg-white flex items-center rounded-lg shadow-sm">
                            <i class="bi bi-cloud-arrow-down-fill text-gray-500 mr-2"></i>
                            <input type="file" class="w-full text-gray-600">
                        </div>
                    </div>
                </div>
                <h3 class="font-bold text-lg mt-4">Portofolio :</h3>
                <div class="grid grid-cols-2 gap-6 mt-2">
                    <p class="text-gray-700">BUKTI PENDUKUNG</p>
                    <p class="text-gray-700">NASKAH PRODUKTIF INOVATIF</p>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button id="closeModal"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg text-lg font-bold shadow-md border border-white">Tutup</button>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });
    </script>
</body>

</html>
