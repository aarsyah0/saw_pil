<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    @stack('head')
</head>

<body class="bg-white flex min-h-screen">

    {{-- Sidebar --}}
    @include('admin.layouts.partials.sidebar')

    {{-- Main area --}}
    <div class="flex-1 ml-[20%] flex flex-col">
        {{-- Header --}}
        @include('admin.layouts.partials.header')

        {{-- Page Content --}}
        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    {{-- Global toggle script for dropdown --}}
    <script>
        function toggleDropdown(id) {
            const d = document.getElementById(id),
                icon = document.getElementById(id + 'Icon');
            d.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>

    @stack('scripts')
</body>

</html>
