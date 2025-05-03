<aside class="w-1/5 bg-[#E7EFF6] text-black p-5 border-r-2 border-gray-300 fixed h-screen overflow-y-auto">
    <div class="flex items-center justify-center mb-5">
        <a href="{{ route('admin.dashboard') }}">
            <img src="/images/pilmapres.png" alt="PILMAPRES" class="w-16">
        </a>
    </div>
    <nav>
        <ul>
            <!-- Dashboard -->
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                    {{ Request::routeIs('admin.dashboard') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                </a>
            </li>

            <!-- Manajemen Akun -->
            <li class="mb-2">
                <a href="{{ route('admin.manajemen-akun') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                    {{ Request::routeIs('admin.manajemen-akun') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-people-fill text-lg mr-3"></i>
                    Manajemen Akun
                </a>
            </li>


            <!-- Verifikasi Berkas CU -->
            <li class="mb-2">
                <a href="{{ route('admin.verification.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                    {{ Request::routeIs('admin.verifikasi-berkas') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-folder-fill text-lg mr-3"></i>
                    Verifikasi Berkas
                </a>
            </li>

            <!-- Rubrik & Kategori -->
            <!-- Rubrik & Kategori -->
            <li class="mb-2" x-data="{ openRubrik: false }">
                <button @click="openRubrik = !openRubrik"
                    class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-gray-200 transition
               {{ Request::routeIs('admin.bidang-cu.*') || Request::routeIs('admin.level-cu.*') || Request::routeIs('admin.kategori-cu.*') ? 'bg-white font-bold shadow' : '' }}">
                    <div class="flex items-center">
                        <i class="bi bi-journal-text text-lg mr-3"></i> Rubrik & Kategori
                    </div>
                    <i :class="openRubrik ? 'bi-chevron-up' : 'bi-chevron-down'" class="bi transition-transform"></i>
                </button>
                <div x-show="openRubrik" class="pl-12 pb-2">
                    <ul>
                        <li class="my-2">
                            <a href="{{ route('admin.bidang-cu.index') }}"
                                class="flex items-center py-2 px-4 rounded-lg hover:bg-gray-200 transition
                          {{ Request::routeIs('admin.bidang-cu.*') ? 'bg-white font-bold shadow' : '' }}">
                                <i class="bi bi-layout-text-window-reverse mr-2"></i> Bidang Capaian
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="{{ route('admin.level-cu.index') }}"
                                class="flex items-center py-2 px-4 rounded-lg hover:bg-gray-200 transition
                          {{ Request::routeIs('admin.level-cu.*') ? 'bg-white font-bold shadow' : '' }}">
                                <i class="bi bi-list-ol mr-2"></i> Level CU
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="{{ route('admin.kategori-cu.index') }}"
                                class="flex items-center py-2 px-4 rounded-lg hover:bg-gray-200 transition
                          {{ Request::routeIs('admin.kategori-cu.*') ? 'bg-white font-bold shadow' : '' }}">
                                <i class="bi bi-tags-fill mr-2"></i> Kategori CU
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="{{ route('admin.bobot-kriteria.index') }}"
                                class="flex items-center py-2 px-4 rounded-lg hover:bg-gray-200 transition
                                   {{ Request::routeIs('admin.bobot-kriteria.*') ? 'bg-white font-bold shadow' : '' }}">
                                <i class="bi bi-sliders mr-2"></i> Bobot Kriteria
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- CuSelection-->
            <li class="mb-2" x-data="{ openSaw: false }">
                <button @click="openSaw = !openSaw"
                    class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                    <div class="flex items-center">
                        <i class="bi bi-calculator-fill text-lg mr-3"></i> Cu Selection
                    </div>
                    <i :class="openSaw ? 'bi-chevron-up' : 'bi-chevron-down'" class="bi transition-transform"></i>
                </button>

                {{-- Submenu --}}
                <ul x-show="openSaw" x-cloak class="mt-1 space-y-1 pl-8">
                    <li>
                        <a href="{{ route('admin.cu_selection.index') }}"
                            class="block py-2 px-4 rounded-lg hover:bg-gray-100 transition">
                            Daftar Seleksi CU
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Penjadwalan PI/BI -->
            <li class="mb-2" x-data="{ openJadwal: false }">
                <button @click="openJadwal = !openJadwal"
                    class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                    <div class="flex items-center">
                        <i class="bi bi-calendar-check-fill text-lg mr-3"></i> Penjadwalan PI/BI
                    </div>
                    <i :class="openJadwal ? 'bi-chevron-up' : 'bi-chevron-down'" class="bi transition-transform"></i>
                </button>

                <ul x-show="openJadwal" x-transition class="mt-2 ml-6 space-y-1">
                    <!-- Link ke daftar jadwal -->
                    <li>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="block py-2 px-4 rounded hover:bg-gray-100">
                            <i class="bi bi-list-ul mr-2"></i> Daftar Jadwal
                        </a>
                    </li>
                </ul>
            </li>




            <!-- Monitoring & Laporan -->

            <!-- Pengaturan Landing Page -->
            <li class="mb-2">
                <a href="{{ route('admin.landing-page.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                    {{ Request::routeIs('admin.landing-page.index') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-house-fill text-lg mr-3"></i> Edit Landing Page
                </a>
            </li>

            <li class="mb-2">
                <a href="{{ route('admin.penilaian-akhir.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                    {{ Request::routeIs('admin.landing-page.index') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-clipboard-check text-lg mr-3"></i> Penilaian Akhir

                </a>
            </li>


            <!-- Notifikasi & Eail -->
            <li class="mb-2" x-data="{ openNotif: false }">
                <button @click="openNotif = !openNotif"
                    class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                    <div class="flex items-center">
                        <i class="bi bi-bell-fill text-lg mr-3"></i> Notifikasi & Email
                    </div>
                    <i :class="openNotif ? 'bi-chevron-up' : 'bi-chevron-down'" class="bi transition-transform"></i>
                </button>
                <div x-show="openNotif" class="pl-12 pb-2">
                    <ul>
                        <li class="my-2"><a href=""
                                class="py-2 px-4 rounded-lg hover:bg-gray-200 transition">Manajemen Notifikasi</a></li>
                        <li class="my-2"><a href=""
                                class="py-2 px-4 rounded-lg hover:bg-gray-200 transition">Kirim Email Jadwal</a></li>
                        <li class="my-2"><a href=""
                                class="py-2 px-4 rounded-lg hover:bg-gray-200 transition">Kirim Email Status CU</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Logout -->
            <li class="mt-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center py-3 px-4 rounded-lg bg-red-500 text-white font-bold hover:bg-red-600 transition">
                        <i class="bi bi-box-arrow-right text-lg mr-3"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
