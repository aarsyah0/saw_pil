<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index()
    {
        $berkas = [
            [
                'no' => 1,
                'kategori' => 'Kategori B / Regional',
                'bidang' => 'Karir Organisasi',
                'wujud' => 'Wakil Ketua',
                'nama_berkas' => 'SertifikatLiterasiDigital.pdf',
                'status' => 'Menunggu'
            ],
            [
                'no' => 2,
                'kategori' => 'Kategori B / Regional',
                'bidang' => 'Karir Organisasi',
                'wujud' => 'Wakil Ketua',
                'nama_berkas' => 'SertifikatLiterasiDigital.pdf',
                'status' => 'Menunggu'
            ]
        ];
        
        return view('user.berkas', compact('berkas'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);
        
        $path = $request->file('file')->store('berkas');
        return back()->with('success', 'Berkas berhasil diunggah!');
    }
}