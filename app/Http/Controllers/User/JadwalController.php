<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        return view('user.jadwal');
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'waktu' => 'required|date',
            'tempat' => 'required|string|max:255',
        ]);

        // Simpan perubahan jadwal ke dalam sesi (contoh sementara)
        session([
            'jadwal_nama' => $request->nama,
            'jadwal_waktu' => $request->waktu,
            'jadwal_tempat' => $request->tempat,
        ]);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }
}
