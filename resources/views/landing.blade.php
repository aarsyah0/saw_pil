{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PILMAPRES POLIJE</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700;900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- AOS Animations CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style>
        /* Apply Google Fonts */
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
        }

        h1,
        h2,
        h5,
        .display-3 {
            font-family: 'Playfair Display', serif;
        }

        /* ======================================
   CUSTOM LIST STYLE
====================================== */
        .custom-list li {
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        /* ======================================
   CAROUSEL CAPTION STYLE
====================================== */
        .carousel-caption h1 {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        /* Overlay gelap di atas gambar */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
            pointer-events: none;
        }

        /* Caption/text yang muncul di tengah gambar */
        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            text-align: left;
            z-index: 10;
            color: white;
        }

        /* Judul */
        .carousel-caption h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        /* Subjudul */
        .carousel-caption p.lead {
            font-size: 1.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        }

        /* Tombol dalam caption */
        .carousel-caption .btn {
            position: relative;
            z-index: 20;
            padding: 10px 24px;
            font-size: 1rem;
            border: 2px solid #fff;
            color: #fff;
            background-color: #0dcaf0;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        .carousel-caption .btn:hover {
            background-color: #fff;
            color: #000;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .carousel-caption {
                left: 5%;
            }

            .carousel-caption h1 {
                font-size: 2rem;
            }

            .carousel-caption p.lead {
                font-size: 1rem;
            }

            /* Pastikan ul.navbar-nav relatif agar pseudo-element bisa absolute */
            .navbar-nav {
                position: relative;
            }

            /* Garis custom sebagai pseudo-element */
            .navbar-nav::after {
                content: "";
                position: absolute;
                bottom: 0;
                /* di bawah item */
                left: var(--underline-left, 0);
                /* di‐set lewat JS */
                width: var(--underline-width, 0);
                /* di‐set lewat JS */
                height: 3px;
                /* ketebalan */
                /* warna primary Bootstrap */
                transition: left .3s ease, width .3s ease;
                /* animasi sliding */
            }

            /* Beri ruang bawah link supaya teks tidak mepet ke garis */
            .navbar-nav .nav-link {
                padding-bottom: 0.5rem;
            }

            /* Hilangkan border/underline bawaan .active (Bootstrap tidak kasih,
   tapi jika ada override lain, ini menjamin hilang) */
            .navbar-nav .nav-link.active {
                border-bottom: none !important;
                text-decoration: none !important;
            }

            /* Section tujuan-pilmapres: buat semua card punya tinggi yang sama */
            .tujuan-pilmapres .card {
                height: 350px;
                width: 100%;
                /* sesuaikan angka dengan kebutuhanmu */
                display: flex;
                flex-direction: column;
            }

            /* Kemudian card-body jadi flex agar konten ter-center */
            .tujuan-pilmapres .card-body {
                flex: 1;
                /* ambil sisa tinggi */
                display: flex;
                flex-direction: column;
                justify-content: center;
                /* vertikal center */
                align-items: center;
                /* horizontal center */
                text-align: center;
                padding: 1.5rem;
                /* spacing konsisten */
            }

            /* Optional: pakai object-fit untuk gambar agar tidak melar */
            .tujuan-pilmapres .card-body img {
                width: 48px;
                height: 48px;
                object-fit: contain;
            }

            .footer-text a {
                color: white;
                /* Warna awal putih */
                text-decoration: none;
                /* Hilangkan garis bawah */
                transition: color 0.3s;
                /* Efek transisi halus */
            }

            .footer-text a:hover,
            .footer-text a:active {
                color: #007bff;
                /* Biru saat hover/klik */
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    {{-- Hero Section --}}
    <header class="hero-section" id="beranda">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="fade-in"
            data-aos-duration="1000">
            <div class="carousel-inner">
                @foreach ($heroSlides as $i => $slide)
                    <div class="carousel-item @if ($i == 0) active @endif">
                        <div class="overlay"></div>
                        @if ($slide->image_path)
                            <img src="{{ asset('storage/' . $slide->image_path) }}" class="d-block w-100 hero-img"
                                alt="{{ $slide->title }}">
                        @endif
                        <div class="carousel-caption text-start fade-in" data-aos="zoom-in" data-aos-duration="800">
                            <h1 class="fw-bold display-3">{{ $slide->title }}</h1>
                            @if ($slide->subtitle)
                                <p class="lead">{{ $slide->subtitle }}</p>
                            @endif
                            @if ($slide->button_text && $slide->button_url)
                                <a href="{{ $slide->button_url }}"
                                    class="btn btn-outline-light mt-3">{{ $slide->button_text }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </header>

    {{-- Introduction Section --}}
    <section class="container my-5" id="intro">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="600">
                <img src="{{ asset('images/winner.png') }}" class="img-fluid" alt="Winner">
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="600">
                <h2 class="fw-bold text-primary">PILMAPRES</h2>
                <p>Pemilihan Mahasiswa Berprestasi (PILMAPRES) adalah ajang bergengsi bagi mahasiswa berprestasi ...</p>
                <button class="btn btn-outline-dark btn-custom btn-filled"
                    onclick="location.href='{{ route('register') }}'">
                    Daftar Sekarang!!
                </button>

            </div>
        </div>
    </section>

    {{-- Tujuan Pilmapres Section --}}
    <section class="container my-5 tujuan-pilmapres" id="tujuan">
        <h2 class="mb-4 text-center" data-aos="fade-down" data-aos-duration="600">
            Tujuan Pilmapres
        </h2>
        <div class="row g-4 align-items-stretch">
            @foreach ($purposes as $p)
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <img src="{{ asset('images/check-icon.png') }}" alt="Checklist Icon" class="mb-3"
                                data-aos="flip-left" data-aos-duration="800">
                            <h5 class="card-title fw-bold">{{ $p->title }}</h5>
                            <p class="card-text text-muted mt-2">{{ $p->description ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    {{-- Persyaratan Peserta Section --}}
    <section class="container my-5" id="persyaratan">
        <h2 class="fw-bold mb-3 text-center" data-aos="fade-down" data-aos-duration="600">PERSYARATAN PESERTA</h2>
        <div class="row">
            <div class="col-md-7">
                <ol class="custom-list">
                    @foreach ($requirements as $req)
                        <li data-aos="fade-right" data-aos-duration="500">{{ $req->text }}</li>
                    @endforeach
                </ol>
            </div>
            <div class="col-md-5 text-end" data-aos="fade-left" data-aos-duration="500">
                <img src="{{ asset('images/pilmapres.png') }}" class="logo-pilmapres" alt="Pilmapres Logo">
            </div>
        </div>
    </section>

    {{-- Jadwal Pelaksanaan Section --}}
    <section class="container my-5" id="jadwal">
        <h2 class="fw-bold text-primary mb-3 text-center" data-aos="fade-down" data-aos-duration="600">JADWAL
            PELAKSANAAN PILMAPRES</h2>
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="zoom-in-right" data-aos-duration="600">
                <img src="{{ asset('images/time1.png') }}" class="img-fluid" alt="Jadwal Pilmapres">
            </div>
            <div class="col-md-6" data-aos="zoom-in-left" data-aos-duration="600">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $i => $sc)
                                <tr data-aos="fade-up" data-aos-duration="400">
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $sc->time }}</td>
                                    <td>{{ $sc->activity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: false,
                mirror: true
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navUl = document.querySelector('.navbar-nav');
            const links = navUl.querySelectorAll('.nav-link');

            function updateUnderline(el) {
                navUl.style.setProperty('--underline-left', el.offsetLeft + 'px');
                navUl.style.setProperty('--underline-width', el.offsetWidth + 'px');
            }

            // set awal ke .active atau ke link pertama
            const initial = navUl.querySelector('.nav-link.active') || links[0];
            updateUnderline(initial);

            links.forEach(link => {
                link.addEventListener('click', () => {
                    links.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                    updateUnderline(link);
                });
            });
        });
    </script>


</body>

</html>
