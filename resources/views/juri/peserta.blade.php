<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peserta</title>

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
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                    </a>
                </li>
                </li>
                <li class="mb-2">
                    <a href="{{ route('juri.peserta') }}"
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow hover:bg-gray-200 transition">
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
                <h1 class="text-2xl font-bold">Peserta</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>


        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-center text-xl font-semibold mb-4">Informasi Peserta</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">No</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Ahmad</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 text-xl"><i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Budi Doremi</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 text-xl"><i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">3</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Arif S</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 text-xl"><i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">4</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Salman</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 text-xl"><i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">5</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Wahyu</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 text-xl"><i class="bi bi-info-circle"></i></a>
                        </td>
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
