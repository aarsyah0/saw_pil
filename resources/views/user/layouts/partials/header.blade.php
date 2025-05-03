<div class="bg-[#E7EFF6] p-6 rounded-lg shadow-md mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">@yield('page_title', 'Dashboard')</h1>
        <span class="text-gray-700">Good morning, <strong>{{ Auth::user()->name }}</strong></span>
    </div>
</div>
