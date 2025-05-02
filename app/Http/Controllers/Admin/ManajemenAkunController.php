<?php
// app/Http/Controllers/Admin/ManajemenAkunController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ManajemenAkunController extends Controller
{
    /**
     * Tampilkan halaman Manajemen Akun
     */
    public function index()
    {
        return view('admin.manajemenakun');
    }
}
