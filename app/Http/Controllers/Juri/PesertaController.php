<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = [
            ['id' => 1, 'nama' => 'Ahmad'],
            ['id' => 2, 'nama' => 'Budi Doremi'],
            ['id' => 3, 'nama' => 'Arif S'],
            ['id' => 4, 'nama' => 'Salman'],
            ['id' => 5, 'nama' => 'Wahyu']
        ];

        return view('juri.peserta', compact('peserta'));
    }
}
