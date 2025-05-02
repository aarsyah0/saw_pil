<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-3" href="#">
            <img src="{{ asset('images/lg.png') }}" alt="Logo JTI" class="logo-navbar">
            <img src="{{ asset('images/pilmapres.png') }}" alt="Logo Pilmapres" class="logo-navbar">
            <span class="fw-bold logo-text">PILMAPRES</span>
        </a>

        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#persyaratan">Informasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#jadwal">Jadwal</a>
                </li>
                <!-- Tombol masuk & daftar masuk ke dalam menu saat mobile -->
                <li class="nav-item d-lg-none">
                    <a href="#" class="btn-custom btn-outline">Masuk</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="#" class="btn-custom btn-filled">Daftar</a>
                </li>
            </ul>
        </div>

        <!-- Tombol Masuk & Daftar (hanya tampil di desktop) -->
        <div class="d-none d-lg-flex align-items-center gap-3 ms-4"> <!-- Tambahkan ms-4 -->
            <a href="{{ route('login') }}" class="btn-custom btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="btn-custom btn-filled">Daftar</a>
        </div>

    </div>
</nav>
