<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

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
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow">
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
                <h1 class="text-2xl font-bold">Profile</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>

        <div class="bg-white p-8 -lg -lg mt-6">
            <div class="flex items-center mb-7">
                <img src="/images/Userimage.png" alt="User Avatar" class="h-20 w-20 rounded-full">
                {{-- <div class="ml-4">
                    <p class="text-lg font-semibold">Good morning, <span class="text-blue-600">John Doe</span></p>
                </div> --}}
            </div>

            <form>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold">Name</label>
                        <input type="text" class="w-full p-2 border rounded-lg" value="John Doe">
                    </div>
                    <div>
                        <label class="block font-semibold">Username</label>
                        <input type="text" class="w-full p-2 border rounded-lg" value="johndoe123">
                    </div>
                    <div>
                        <label class="block font-semibold">NIM</label>
                        <input type="text" class="w-full p-2 border rounded-lg" value="12345678">
                    </div>
                    <div>
                        <label class="block font-semibold">No. Handphone</label>
                        <input type="text" class="w-full p-2 border rounded-lg" value="081234567890">
                    </div>
                    <div>
                        <label class="block font-semibold">Email</label>
                        <input type="email" class="w-full p-2 border rounded-lg" value="johndoe@email.com">
                    </div>
                    <div>
                        <label class="block font-semibold">Jurusan</label>
                        <input type="text" class="w-full p-2 border rounded-lg" value="Teknik Informatika">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">Update Profile</button>
            </form>
        </div>
    </main>
</body>

</html>
