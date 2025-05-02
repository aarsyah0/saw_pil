<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Juri</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-white flex">
    <!-- Sidebar -->
    <!-- Sidebar -->
    <aside class="w-1/5 bg-[#E7EFF6] text-black p-5 border-r-2 border-gray-300 h-screen fixed overflow-y-auto">
        <div class="flex items-center justify-center mb-5">
            <img src="/images/pilmapres.png" alt="PILMAPRES" class="w-16">
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('juri.dashboard') }}"
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow hover:bg-gray-200 transition">
                        <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                    </a>
                </li>
                </li>
                <li class="mb-2">
                    <a href="{{ route('juri.peserta') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-person text-lg mr-3"></i> Peserta
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('juri.jadwal') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-alarm text-lg mr-3"></i> Jadwal
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('juri.presentasi') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-pie-chart  text-lg mr-3"></i> Presentasi
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

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto ml-[20%]">
        <!-- Card 1: Header Dashboard -->
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>


        <div class="flex justify-center gap-16 mt-8">
            <!-- Card Pengguna -->
            <div class="bg-gray-100 p-5 rounded-3xl shadow-md flex items-center w-60 h-36">
                <div class="flex-shrink-0 mr-3">
                    <i class="bi bi-people-fill text-5xl text-gray-700"></i>
                </div>
                <div class="flex flex-col pl-10">
                    <h5 class="text-lg font-semibold text-gray-600">Peserta</h9>
                        <h2 class="text-3xl font-bold text-gray-800 mt-4">10</h2>
                </div>
            </div>

            <!-- Card Berkas -->
            <div class="bg-gray-100 p-5 rounded-3xl shadow-md flex items-center w-60 h-36">
                <div class="flex-shrink-0 mr-3">
                    <i class="bi bi-file-earmark-fill text-5xl text-gray-700"></i>
                </div>
                <div class="flex flex-col pl-10">
                    <h5 class="text-lg font-semibold text-gray-600">Jadwal</h5>
                    <h2 class="text-3xl font-bold text-gray-800 mt-4">7</h2>
                </div>
            </div>
        </div>

        <!-- Card 3: Tabel Berkas -->
        <div class="bg-white p-8 mt-8 rounded-lg shadow-md ">
            <h4 class="text-xl font-semibold mb-4">Jadwal hari ini</h4>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3 text-left">No</th>
                        <th class="border p-3 text-left">Mahasiswa</th>
                        <th class="border p-3 text-center">Waktu</th>
                        <th class="border p-3 text-center">Tanggal</th>
                        <th class="border p-3 text-center">Tempat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-3 text-center">1</td>
                        <td class="border p-3 text-center">Budi Doremi</td>
                        <td class="border p-3 text-center">08.00</td>
                        <td class="border p-3 text-center">10 Maret 2025</td>
                        <td class="border p-3 text-center">Gedung A3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById('dataAlternatifIcon');

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                dropdown.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</body>

</html>
