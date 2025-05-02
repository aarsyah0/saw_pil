<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkas</title>
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
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow hover:bg-gray-200 transitio">
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
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Berkas</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-3xl font-semibold text-center leading-tight">Capaian Unggulan</h2>
            <br>
            <button onclick="toggleModal()"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Unggah Berkas</button>

            <table class="w-full mt-4 border-collapse border border-gray-300 text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">Bidang</th>
                        <th class="border p-2">Wujud</th>
                        <th class="border p-2">Nama Berkas</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berkas as $b)
                        <tr>
                            <td class="border p-2">{{ $b['no'] }}</td>
                            <td class="border p-2">{{ $b['kategori'] }}</td>
                            <td class="border p-2">{{ $b['bidang'] }}</td>
                            <td class="border p-2">{{ $b['wujud'] }}</td>
                            <td class="border p-2">{{ $b['nama_berkas'] }}</td>
                            <td class="border p-2 text-yellow-500">{{ $b['status'] }}</td>
                            <td class="border p-2">
                                <button class="text-blue-500 hover:text-blue-700">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Pop-up -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-[#E7EFF6] p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-center">Unggah Berkas</h2>
            <form action="{{ route('berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <label class="block mb-2">Kategori</label>
                <select name="kategori" class="border p-2 w-full rounded-lg">
                    <option value="">Pilih Kategori</option>
                </select>

                <label class="block mt-4 mb-2">Bidang</label>
                <select name="bidang" class="border p-2 w-full rounded-lg">
                    <option value="">Pilih Bidang</option>
                </select>

                <label class="block mt-4 mb-2">Wujud Capaian</label>
                <select name="wujud" class="border p-2 w-full rounded-lg">
                    <option value="">Pilih Wujud Capaian</option>
                </select>

                <label class="block mt-4 mb-2">Choose file</label>
                <input type="file" name="file" class="border p-2 w-full rounded-lg">

                <div class="flex justify-end mt-4">
                    <button type="button" onclick="toggleModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">BATAL</button>
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg ml-2 hover:bg-green-600 transition">UNGGAH</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            document.getElementById('uploadModal').classList.toggle('hidden');
        }
    </script>
</body>

</html>
