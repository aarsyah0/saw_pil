<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
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
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow hover:bg-gray-200 transition">
                        <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.profile') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-person-circle text-lg mr-3"></i> Profile
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('berkas.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        <i class="bi bi-folder-fill text-lg mr-3"></i> Berkas
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

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto ml-[20%]">
        <!-- Card 1: Header Dashboard -->
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>

        <!-- Card 2: Content -->
        <div class="bg-white p-8 -lg -md mt-6">
            <h2 class="text-3xl font-semibold text-center leading-tight">
                Pemilihan Mahasiswa Berprestasi <br>
                Politeknik Negeri Jember
            </h2>
            <br>
            <div class="flex mt-6 gap-6">
                <img src="/images/pilmapres-cartoon.png" class="rounded-lg shadow-lg w-1/3" alt="Pilmapres">
                <p class="text-gray-800 text-lg leading-loose ml-10">
                    Pemilihan Mahasiswa Berprestasi (PILMAPRES) di Politeknik Negeri Jember (Polije) adalah ajang
                    tahunan yang bertujuan untuk mengapresiasi dan mendorong mahasiswa dalam mencapai prestasi akademik
                    dan non-akademik.
                    Pada tahun 2025, Polije telah membuka pendaftaran PILMAPRES, yang diumumkan melalui akun Instagram
                    resmi Polije.<br><br>
                    Mahasiswa yang tertarik untuk berpartisipasi dalam PILMAPRES 2025 di Polije dapat mengikuti jadwal
                    dan informasi yang telah diumumkan.
                    Untuk informasi lebih lanjut mengenai persyaratan, jadwal, dan prosedur pendaftaran, disarankan
                    untuk mengunjungi situs resmi Polije atau menghubungi panitia PILMAPRES di kampus.
                </p>
            </div>
        </div>
    </main>
</body>

</html>
