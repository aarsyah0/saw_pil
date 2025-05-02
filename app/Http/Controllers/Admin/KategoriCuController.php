<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriCu;
use App\Models\BidangCu;
use App\Models\LevelCu;
use Illuminate\Http\Request;

class KategoriCuController extends Controller
{
    public function index()
    {
        $bidangs = BidangCu::orderBy('nama')->get();
        $levels  = LevelCu::orderBy('level')->get();
        $kategoris = KategoriCu::with(['bidang','level'])
                               ->orderBy('bidang_id')
                               ->orderBy('wujud_cu')
                               ->get();

        return view('admin.kategori', compact('bidangs','levels','kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bidang_id'  => 'required|exists:bidang_cu,id',
            'wujud_cu'   => 'required|string|max:100',
            'kode'       => 'required|string|max:4',
            'level_id'   => 'required|exists:level_cu,level',
            'skor'       => 'required|numeric|min:0',
        ]);

        KategoriCu::create($request->only('bidang_id','wujud_cu','kode','level_id','skor'));

        return redirect()->route('admin.kategori-cu.index')
                         ->with('success','Kategori CU berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriCu $kategoriCu)
{
    $request->validate([
        'bidang_id' => 'required|exists:bidang_cu,id',   // jika Anda juga ingin memperbolehkan ubah bidang
        'level_id'  => 'required|exists:level_cu,level', // tambahkan ini
        'wujud_cu'  => 'required|string|max:100',
        'kode'      => 'required|string|max:4',
        'skor'      => 'required|numeric|min:0',
    ]);

    $kategoriCu->update($request->only(
        'bidang_id',  // jika diizinkan
        'level_id',   // sekarang ikut ter‑update
        'wujud_cu',
        'kode',
        'skor'
    ));

    return redirect()->route('admin.kategori-cu.index')
                     ->with('success','Kategori CU berhasil diperbarui.');
}


    public function destroy(KategoriCu $kategoriCu)
    {
        $kategoriCu->delete();

        return redirect()->route('admin.kategori-cu.index')
                         ->with('success','Kategori CU berhasil dihapus.');
    }
}
