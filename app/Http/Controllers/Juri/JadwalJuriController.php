<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalJuriController extends Controller
{
    public function index()
    {
        $jadwal = [
            ['no' => 1, 'mahasiswa' => 'Budi Doremi', 'waktu' => '08.00', 'tanggal' => '20 Maret 2025', 'tempat' => 'Gedung A3'],
        ];

        return view('juri.jadwalJuri', compact('jadwal'));
    }
}
