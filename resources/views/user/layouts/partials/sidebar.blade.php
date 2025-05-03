{{-- resources/views/partials/sidebar.blade.php --}}
<aside class="w-1/5 bg-[#E7EFF6] text-black p-5 border-r-2 border-gray-300 h-screen fixed overflow-y-auto">
    <div class="flex items-center justify-center mb-5">
        <img src="/images/pilmapres.png" alt="PILMAPRES" class="w-16">
    </div>
    <nav>
        <ul>
            @php
                // helper untuk menambahkan kelas aktif
                function isActive($pattern)
                {
                    return request()->routeIs($pattern) ? 'bg-white font-bold' : 'hover:bg-gray-200';
                }
            @endphp

            <li class="mb-2">
                <a href="{{ route('user.dashboard') }}"
                    class="flex items-center py-3 px-4 rounded-lg {{ isActive('user.dashboard') }} transition">
                    <i class="bi bi-grid-1x2-fill text-lg mr-3"></i> Dashboard
                </a>
            </li>

            <li class="mb-2">
                <a href="#"
                    class="flex items-center py-3 px-4 rounded-lg {{ isActive('user.profile') }} transition">
                    <i class="bi bi-person-circle text-lg mr-3"></i> Profile
                </a>
            </li>

            <li class="mb-2">
                <a href="{{ route('berkas.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg {{ isActive('berkas.*') }} transition">
                    <i class="bi bi-folder-fill text-lg mr-3"></i> Berkas
                </a>
            </li>

            <li class="mb-2">
                <a href="#"
                    class="flex items-center py-3 px-4 rounded-lg {{ isActive('user.hasil') }} transition">
                    <i class="bi bi-bar-chart-line-fill text-lg mr-3"></i> Hasil
                </a>
            </li>

            <li class="mb-2">
                <a href="#"
                    class="flex items-center py-3 px-4 rounded-lg {{ isActive('user.jadwal') }} transition">
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
