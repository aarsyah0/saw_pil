<header class="bg-[#E7EFF6] p-6 rounded-lg shadow-md mb-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">@yield('page-title', 'Dashboard')</h1>
        <span class="text-gray-700">
            Halo Selamat Datang, <strong>{{ Auth::user()->name }}</strong>
        </span>
    </div>
</header>
