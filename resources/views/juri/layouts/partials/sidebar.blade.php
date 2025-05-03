<aside class="w-1/5 bg-[#E7EFF6] text-black p-5 border-r-2 border-gray-300 h-screen fixed overflow-y-auto">
    <div class="flex items-center justify-center mb-5">
        <img src="/images/pilmapres.png" alt="PILMAPRES" class="w-16">
    </div>
    <nav>
        <ul>
            <li class="mb-2">
                <a href="{{ route('juri.dashboard') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition {{ Request::routeIs('juri.dashboard') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="#"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition {{ Request::routeIs('juri.peserta') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-person text-lg mr-3"></i> Peserta
                </a>
            </li>
            <li class="mb-2">
                <a href="#"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition {{ Request::routeIs('juri.jadwal') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-alarm text-lg mr-3"></i> Jadwal
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('juri.penilaian.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-200 transition
                          {{ Request::routeIs('juri.penilaian*') ? 'bg-white font-bold shadow' : '' }}">
                    <i class="bi bi-clipboard-check text-lg mr-3"></i> Penilaian
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
