<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentasi</title>

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
                        class="flex items-center py-3 px-4 rounded-lg bg-white text-black font-bold shadow hover:bg-gray-200 transition">
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
                <h1 class="text-2xl font-bold">Presentasi</h1>
                <span class="text-gray-700">Good morning, <strong>Yoshi Toranaga</strong></span>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold text-center mb-4">Data Kategori</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border p-2 bg-gray-100">No</th>
                            <th class="border p-2 bg-gray-100">Nama</th>
                            <th class="border p-2 bg-gray-100">PI</th>
                            <th class="border p-2 bg-gray-100">BI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-2 text-center">1</td>
                            <td class="border p-2 text-center">Ahmad</td>
                            <td class="border p-2 text-center">
                                <div class="flex justify-center items-center">
                                    <button onclick="openModalPI()"
                                        class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                        <span class="inline-block">!</span>
                                    </button>
                                </div>
                            </td>
                            <td class="border p-2 text-center">
                                <div class="flex justify-center items-center">
                                    <button onclick="openModalBI()"
                                        class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                        <span class="inline-block">!</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>

    <!-- Modal Pop-up -->
    <!-- Modal Pop-up for PI -->
    <div id="modalPI" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-11/12 md:w-2/3 lg:w-1/2 p-5 rounded-lg shadow-lg max-h-[80vh] overflow-y-auto relative">
            <h2 class="text-center text-xl font-bold mb-4">Detail PI</h2>
            <button onclick="closeModalPI()" class="absolute top-5 right-5 text-gray-600 text-2xl">&times;</button>
            <hr class="mb-4">
            <form id="formPI">
                <h3 class="font-semibold">Nilai PI:</h3>

                <div class="flex mb-4">
                    <div class="w-1/2 pr-2">
                        <p class="font-medium">PENYAJIAN</p>
                        <p class="text-sm">Penggunaan bahasa Indonesia yang baik dan benar</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="85">

                        <p class="text-sm">Kesesuaian pengerjaan dan sesuai standar</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="90">
                    </div>

                    <div class="w-1/2 pl-2">
                        <p class="font-medium">SOLUSI</p>
                        <p class="text-sm">Uraian mengenai pihak penerima manfaat</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="80">

                        <p class="text-sm">Rincian langkah-langkah untuk mencapai solusi</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="88">
                    </div>
                </div>

                <h3 class="font-semibold mt-4">Nilai Presentasi:</h3>
                <div class="flex mb-4">
                    <div class="w-1/2 pr-2">
                        <p>Content</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="86">

                        <p>Accuracy</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="88">
                    </div>

                    <div class="w-1/2 pl-2">
                        <p>Fluency</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="85">

                        <p>Pronunciation</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="87">

                        <p>Overall performance</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="89">
                    </div>
                </div>

                <h3 class="text-center font-bold mt-4">NILAI TOTAL : <span id="totalNilai">0</span>/100</h3>

                <!-- Tombol Kirim -->
                <div class="flex justify-center mt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Pop-up for BI -->
    <div id="modalBI" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-11/12 md:w-2/3 lg:w-1/2 p-5 rounded-lg shadow-lg max-h-[80vh] overflow-y-auto relative">
            <h2 class="text-center text-xl font-bold mb-4">Detail BI</h2>
            <button onclick="closeModalBI()" class="absolute top-5 right-5 text-gray-600 text-2xl">&times;</button>
            <hr class="mb-4">
            <form id="formBI">
                <h3 class="font-semibold">Nilai BI:</h3>

                <div class="flex mb-4">
                    <div class="w-1/2 pr-2">
                        <p class="font-medium">PENYAJIAN</p>
                        <p class="text-sm">Penggunaan bahasa Indonesia yang baik dan benar</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="85">

                        <p class="text-sm">Kesesuaian pengerjaan dan sesuai standar</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="90">
                    </div>

                    <div class="w-1/2 pl-2">
                        <p class="font-medium">SOLUSI</p>
                        <p class="text-sm">Uraian mengenai pihak penerima manfaat</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="80">

                        <p class="text-sm">Rincian langkah-langkah untuk mencapai solusi</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="88">
                    </div>
                </div>

                <div class="flex mb-4">
                    <div class="w-1/2 pr-2">
                        <p class="font-medium">SUBTANSI PRODUK INOVATIF</p>
                        <p class="text-sm">Fakta atau gejala lingkungan yang menarik</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="82">

                        <p class="text-sm">Identifikasi masalah yang terdapat dalam fakta</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="86">

                        <p class="text-sm">Adanya urutan pihak terdampak</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="89">

                        <p class="font-medium mt-4">CAPAIAN UNGGULAN</p>
                        <p class="text-sm">Nilai ekspansi unggulan</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="84">
                    </div>

                    <div class="w-1/2 pl-2">
                        <p class="text-sm">Uraian mengenai sumber daya</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="87">

                        <p class="text-sm">Uraian mengenai pihak penerima manfaat</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="88">

                        <p class="text-sm">Uraian mengenai solusi yang berciri smart</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="85">

                        <p class="font-medium mt-4">KUALITAS PRODUK INOVATIF</p>
                        <p class="text-sm">Keunikan produk</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="90">

                        <p class="text-sm">Kualitas produk</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="91">

                        <p class="text-sm">Kelejakan produk</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="92">
                    </div>
                </div>

                <h3 class="font-semibold mt-4">Nilai Presentasi:</h3>
                <div class="flex mb-4">
                    <div class="w-1/2 pr-2">
                        <p>Content</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="86">

                        <p>Accuracy</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="88">
                    </div>

                    <div class="w-1/2 pl-2">
                        <p>Fluency</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="85">

                        <p>Pronunciation</p>
                        <input type="number" class="w-full border p-2 rounded mb-2 nilai-input" value="87">

                        <p>Overall performance</p>
                        <input type="number" class="w-full border p-2 rounded nilai-input" value="89">
                    </div>
                </div>

                <h3 class="text-center font-bold mt-4">NILAI TOTAL: <span id="totalNilaiBI">0</span> / 100</h3>

                <!-- Tombol Kirim -->
                <div class="flex justify-center mt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table with buttons that trigger the popups -->


    <script>
        function openModalPI() {
            document.getElementById("modalPI").classList.remove("hidden");
        }

        function closeModalPI() {
            document.getElementById("modalPI").classList.add("hidden");
        }

        function openModalBI() {
            document.getElementById("modalBI").classList.remove("hidden");
        }

        function closeModalBI() {
            document.getElementById("modalBI").classList.add("hidden");
        }
        document.getElementById('formPI').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload halaman
            alert('Data berhasil dikirim!');
            closeModalPI();
        });

        function hitungTotalNilai() {
            let inputs = document.querySelectorAll('.nilai-input');
            let total = 0;

            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            let nilaiAkhir = (total / (inputs.length * 100)) * 100; // Normalisasi ke skala 100
            document.getElementById('totalNilai').textContent = nilaiAkhir.toFixed(2);
        }

        document.querySelectorAll('.nilai-input').forEach(input => {
            input.addEventListener('input', hitungTotalNilai);
        });

        document.addEventListener('DOMContentLoaded', hitungTotalNilai);
        document.getElementById('formBI').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload halaman
            alert('Data berhasil dikirim!');
            closeModalBI();
        });

        function hitungTotalNilaiBI() {
            let inputs = document.querySelectorAll('#modalBI .nilai-input');
            let total = 0;

            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            let nilaiAkhir = (total / (inputs.length * 100)) * 100; // Normalisasi ke skala 100
            document.getElementById('totalNilaiBI').textContent = nilaiAkhir.toFixed(2);
        }

        document.querySelectorAll('#modalBI .nilai-input').forEach(input => {
            input.addEventListener('input', hitungTotalNilaiBI);
        });

        document.addEventListener('DOMContentLoaded', hitungTotalNilaiBI);
    </script>

</body>

</html>
