<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-white flex">
    <!-- Sidebar -->
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
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-bar-chart-line-fill text-lg mr-3"></i> Hasil
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.jadwal') }}"
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow">
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

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto ml-[20%]">
        <!-- Header -->
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">JADWAL</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>

        <!-- Card Jadwal -->
        <div class="bg-white p-8 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold text-center mb-6">JADWAL PRESENTASI</h2>
            <div class="grid grid-cols-3 gap-4 text-lg font-semibold">
                <p class="border-b pb-2">Nama</p>
                <p class="border-b pb-2">Waktu</p>
                <p class="border-b pb-2">Tempat</p>
            </div>
            <!-- Contoh Data -->
            <div class="grid grid-cols-3 gap-4 text-gray-700 mt-4">
                <p class="border-b pb-2">John Doe</p>
                <p class="border-b pb-2">10 Maret 2025, 10:00 AM</p>
                <p class="border-b pb-2">Ruang A101</p>
            </div>
            <div class="grid grid-cols-3 gap-4 text-gray-700 mt-2">
                <p class="border-b pb-2">Jane Smith</p>
                <p class="border-b pb-2">12 Maret 2025, 02:00 PM</p>
                <p class="border-b pb-2">Ruang B202</p>
            </div>
        </div>
    </main>
</body>

</html>
