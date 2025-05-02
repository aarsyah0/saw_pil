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

        .btn-outline-dark {
            font-weight: 600;
        }

        .carousel-caption h1 {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .custom-list li {
            margin-bottom: .75rem;
            font-weight: 500;
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
                <button class="btn btn-outline-dark">Daftar Sekarang!!</button>
            </div>
        </div>
    </section>

    {{-- Tujuan Pilmapres Section --}}
    <section class="container my-5 tujuan-pilmapres" id="tujuan">
        <h2 class="mb-4 text-center" data-aos="fade-down" data-aos-duration="600">Tujuan Pilmapres</h2>
        <div class="row g-4">
            @foreach ($purposes as $p)
                <div class="col-sm-6 col-md-4" data-aos="fade-up" data-aos-offset="200" data-aos-easing="ease-in-out"
                    data-aos-duration="600">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset('images/check-icon.png') }}" alt="Checklist Icon" class="mb-3"
                                style="width: 48px; height: 48px;" data-aos="flip-left" data-aos-duration="800">
                            <h5 class="card-title fw-bold">{{ $p->title }}</h5>
                            <p class="card-text text-muted">{{ $p->description ?? '-' }}</p>
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
    <!-- Custom JS -->
    <script src="{{ asset('js/landing.js') }}"></script>
</body>

</html>
