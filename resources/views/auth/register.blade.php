<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('{{ asset('images/polije.png') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            overflow-y: auto;
            position: relative;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .register-container {
            position: relative;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 480px;
            margin: 2rem auto;
            z-index: 1;
        }

        /* Jika ingin tweak tambahan untuk layar sangat besar */
        @media (min-width: 1200px) {
            .register-container {
                padding: 3rem;
            }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="register-container">
            <!-- Tombol Kembali -->
            <div class="mb-4 text-start">
                <a href="{{ url('/') }}" class="btn btn-secondary">&larr; </a>
            </div>
            <div class="text-center mb-4">
                <img src="{{ asset('images/pilmapres.png') }}" alt="Logo" class="img-fluid" style="max-width:80px;">
            </div>

            <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="nim" class="form-control" placeholder="No. Induk Mahasiswa"
                        required>
                </div>
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6">
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                            required>
                    </div>
                    <div class="col-12 col-md-6">
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="" disabled selected>Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" name="no_hp" class="form-control" placeholder="No. Handphone" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6">
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <input type="text" name="prodi" class="form-control" placeholder="Prodi" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="foto" class="form-label">Upload Foto</label>
                    <input type="file" name="foto" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">DAFTAR</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
