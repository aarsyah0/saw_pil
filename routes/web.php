<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\BerkasController as BerkasUser;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\JadwalController;
use App\Http\Controllers\User\HasilController;
use App\Http\Controllers\Admin\dataBidangController;
use App\Http\Controllers\Admin\dataWujudController;
use App\Http\Controllers\Admin\dataKategoriController;
use App\Http\Controllers\Admin\BasisPengetahuanController;
use App\Http\Controllers\Admin\LandingPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PenilaianAlternatifController;
use App\Http\Controllers\Admin\ProsesPerhitunganController;
use App\Http\Controllers\Admin\JadwalAdminController;
use App\Http\Controllers\Admin\DataHasilController;
use App\Http\Controllers\Juri\DashboardJuriController;
use App\Http\Controllers\Juri\PesertaController;
use App\Http\Controllers\Juri\JadwalJuriController;
use App\Http\Controllers\Juri\PresentasiController;
use App\Http\Controllers\Admin\ManajemenAkunController;
use App\Http\Controllers\Admin\VerifikasiBerkasController;
use App\Http\Controllers\Admin\BidangCuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\LevelCuController;
use App\Http\Controllers\Admin\KategoriCuController;
use App\Http\Controllers\Admin\CuVerificationController;
use App\Http\Controllers\Admin\CuSelectionController;
use App\Http\Controllers\Admin\SchedulePiBiController;
use App\Http\Controllers\Admin\BobotKriteriaController;
use App\Http\Controllers\Admin\PenilaianAkhirController;
use App\Http\Controllers\Juri\PenilaianJuriController;


Route::get('/', [LandingController::class, 'index'])->name('landing');


// Halaman Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


Route::prefix('admin')->group(function () {
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('admin.landing-page.index');
});
// Middleware User
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserDashboard::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [UserDashboard::class, 'updateProfile'])->name('user.profile.update');
});


Route::get('/user/berkas', [BerkasUser::class, 'index'])->name('berkas.index');
Route::post('/user/berkas/upload', [BerkasUser::class, 'upload'])->name('berkas.upload');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/jadwal', [JadwalController::class, 'index'])->name('user.jadwal');
    Route::put('/user/jadwal/update', [JadwalController::class, 'update'])->name('user.jadwal.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/hasil', [HasilController::class, 'index'])->name('user.hasil');
});

//Middleware Juri
Route::middleware([\App\Http\Middleware\JuriMiddleware::class])->group(function () {
    Route::get('/juri/dashboard', [DashboardJuriController::class, 'index'])->name('juri.dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/juri/peserta', [PesertaController::class, 'index'])->name('juri.peserta');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/juri/jadwal', [JadwalJuriController::class, 'index'])->name('juri.jadwal');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/juri/presentasi', [PresentasiController::class, 'index'])->name('juri.presentasi');
});
Route::middleware(['auth','admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class,'index'])->name('dashboard');

    // Landing page overview
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page.index');

    // Hero Slide Routes
    Route::post('/hero-slides', [LandingPageController::class, 'storeHeroSlide'])->name('hero-slides.store');
Route::put('/hero-slides/{heroSlide}', [LandingPageController::class, 'updateHeroSlide'])->name('hero-slides.update');
Route::delete('/hero-slides/{heroSlide}', [LandingPageController::class, 'destroyHeroSlide'])->name('hero-slides.destroy');

Route::post('/purposes', [LandingPageController::class, 'storePurpose'])->name('purposes.store');
Route::put('/purposes/{purpose}', [LandingPageController::class, 'updatePurpose'])->name('purposes.update');
Route::delete('/purposes/{purpose}', [LandingPageController::class, 'destroyPurpose'])->name('purposes.destroy');

Route::post('/requirements', [LandingPageController::class, 'storeRequirement'])->name('requirements.store');
Route::put('/requirements/{requirement}', [LandingPageController::class, 'updateRequirement'])->name('requirements.update');
Route::delete('/requirements/{requirement}', [LandingPageController::class, 'destroyRequirement'])->name('requirements.destroy');

Route::post('/schedules', [LandingPageController::class, 'storeSchedule'])->name('schedules.store');
Route::put('/schedules/{schedule}', [LandingPageController::class, 'updateSchedule'])->name('schedules.update');
Route::delete('/schedules/{schedule}', [LandingPageController::class, 'destroySchedule'])->name('schedules.destroy');


    // other admin modules…
    Route::get('data-bidang',        [dataBidangController::class,'index'])->name('dataBidang');
    Route::get('data-wujud',         [dataWujudController::class,'index'])->name('dataWujud');
    Route::get('data-kategori',      [dataKategoriController::class,'index'])->name('dataKategori');
    Route::get('basis-pengetahuan',  [BasisPengetahuanController::class,'index'])->name('basisPengetahuan');
    Route::get('data-hasil',         [DataHasilController::class,'index'])->name('dataHasil');
    Route::get('jadwal',             [JadwalAdminController::class,'index'])->name('jadwal.index');
    Route::get('jadwal/create',      [JadwalAdminController::class,'create'])->name('jadwal.create');
    Route::post('jadwal',            [JadwalAdminController::class,'store'])->name('jadwal.store');
    Route::get('proses-perhitungan', [ProsesPerhitunganController::class,'index'])->name('proses-perhitungan');
    Route::get('penilaian-alternatif',          [PenilaianAlternatifController::class,'index'])->name('penilaian-alternatif');
    Route::post('penilaian-alternatif/update',  [PenilaianAlternatifController::class,'update'])->name('penilaian-alternatif.update');
    Route::get('manajemen-akun', [ManajemenAkunController::class, 'index'])
    ->name('manajemen-akun');
    Route::get('verifikasi-berkas', [VerifikasiBerkasController::class, 'index'])
    ->name('verifikasi-berkas');

});


Route::prefix('admin')
     ->name('admin.')
     ->middleware('auth')  // atau hilangkan sama sekali jika tidak perlu auth
     ->group(function () {

    // Daftar Bidang CU
    Route::get('bidang-cu', [BidangCuController::class, 'index'])
         ->name('bidang-cu.index');

    // Form tambah
    Route::get('bidang-cu/create', [BidangCuController::class, 'create'])
         ->name('bidang-cu.create');

    // Simpan data baru
    Route::post('bidang-cu', [BidangCuController::class, 'store'])
         ->name('bidang-cu.store');

    // Form edit
    Route::get('bidang-cu/{bidangCu}/edit', [BidangCuController::class, 'edit'])
         ->name('bidang-cu.edit');

    // Update data
    Route::put('bidang-cu/{bidangCu}', [BidangCuController::class, 'update'])
         ->name('bidang-cu.update');

    // Hapus data
    Route::delete('bidang-cu/{bidangCu}', [BidangCuController::class, 'destroy'])
         ->name('bidang-cu.destroy');
});


Route::prefix('admin')
     ->name('admin.')
     ->middleware('auth')
     ->group(function(){
         // Level CU
         Route::get   ('level-cu',              [LevelCuController::class,'index'])  ->name('level-cu.index');
         Route::post  ('level-cu',              [LevelCuController::class,'store'])  ->name('level-cu.store');
         Route::put   ('level-cu/{level}',      [LevelCuController::class,'update']) ->name('level-cu.update');
         Route::delete('level-cu/{level}',      [LevelCuController::class,'destroy'])->name('level-cu.destroy');
     });


     Route::prefix('admin')
          ->name('admin.')
          ->middleware('auth')
          ->group(function(){
              // Kategori CU
              Route::get    ('kategori-cu',              [KategoriCuController::class,'index'])  ->name('kategori-cu.index');
              Route::post   ('kategori-cu',              [KategoriCuController::class,'store'])  ->name('kategori-cu.store');
              Route::put    ('kategori-cu/{kategoriCu}', [KategoriCuController::class,'update']) ->name('kategori-cu.update');
              Route::delete ('kategori-cu/{kategoriCu}', [KategoriCuController::class,'destroy'])->name('kategori-cu.destroy');
          });
// routes/web.php



Route::middleware(['auth'])   // Hanya auth, tanpa is_admin
     ->prefix('admin')
     ->name('admin.')
     ->group(function() {

    Route::get('cu-verification', [CuVerificationController::class, 'index'])
         ->name('verification.index');

    Route::post('cu-verification/{submission}/approve', [CuVerificationController::class, 'approve'])
         ->name('verification.approve');

    Route::post('cu-verification/{submission}/reject', [CuVerificationController::class, 'reject'])
         ->name('verification.reject');
});

Route::prefix('admin')->name('admin.')->group(function(){
    // daftar CU selection
    Route::get('cu-selection', [CuSelectionController::class,'index'])
         ->name('cu_selection.index');

    // update status by peserta_id
    Route::patch('cu-selection/{peserta_id}/status',
         [CuSelectionController::class,'updateStatus'])
         ->name('cu_selection.update_status');

    // detail per peserta (AJAX)
    Route::get('cu-selection/{peserta_id}/detail',
         [CuSelectionController::class,'showDetail'])
         ->name('cu_selection.detail');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')  // sesuaikan middleware kamu
    ->group(function () {

        // Men-generate semua route: index, create, store, show, edit, update, destroy
        Route::resource('schedules', SchedulePiBiController::class)
            ->parameters(['schedules' => 'id']);

        // Jika kamu tidak perlu show(), kamu bisa kecualikan:
        // Route::resource('schedules', SchedulePiBiController::class)
        //     ->except(['show']);

    });

    Route::prefix('admin')->name('admin.')
     ->middleware('auth')
     ->group(function(){
  Route::resource('schedules', SchedulePiBiController::class)
       ->except(['show']);
  Route::get('schedules/{schedule}/detail',
            [SchedulePiBiController::class,'detail'])
       ->name('schedules.detail');
});


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){
    Route::get('bobot-kriteria', [BobotKriteriaController::class, 'index'])
        ->name('bobot-kriteria.index');
    Route::get('bobot-kriteria/{nama}/edit', [BobotKriteriaController::class, 'edit'])
        ->name('bobot-kriteria.edit');
    Route::put('bobot-kriteria/{nama}', [BobotKriteriaController::class, 'update'])
        ->name('bobot-kriteria.update');
    Route::post('bobot-kriteria', [BobotKriteriaController::class, 'store'])
        ->name('bobot-kriteria.store');

});


Route::middleware('auth')
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){
         // ...
         Route::get('penilaian-akhir', [PenilaianAkhirController::class, 'index'])
              ->name('penilaian-akhir.index');
     });



// routes/web.php

// ... import controller di atas

Route::middleware('auth')
     ->prefix('juri')
     ->name('juri.')
     ->group(function(){

    // Dashboard
    Route::get('dashboard', [DashboardJuriController::class,'index'])
         ->name('dashboard');

    // Peserta, Jadwal, Presentasi...
    Route::get('peserta',   [PesertaController::class,'index'])->name('peserta');
    Route::get('jadwal',    [JadwalJuriController::class,'index'])->name('jadwal');
    Route::get('presentasi',[PresentasiController::class,'index'])->name('presentasi');

    // Penilaian: index + create/store PI/BI
    Route::get('penilaian',                   [PenilaianJuriController::class,'index'])->name('penilaian.index');
    Route::get('penilaian/pi/{schedule}',     [PenilaianJuriController::class,'createPi'])->name('penilaian.pi.create');
    Route::post('penilaian/pi/{schedule}',    [PenilaianJuriController::class,'storePi'])->name('penilaian.pi.store');
    Route::get('penilaian/bi/{schedule}',     [PenilaianJuriController::class,'createBi'])->name('penilaian.bi.create');
    Route::post('penilaian/bi/{schedule}',    [PenilaianJuriController::class,'storeBi'])->name('penilaian.bi.store');

});
