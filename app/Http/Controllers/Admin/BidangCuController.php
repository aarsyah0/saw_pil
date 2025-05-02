<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangCu;
use Illuminate\Http\Request;

class BidangCuController extends Controller
{
    /**
     * Tampilkan halaman index (dengan modal create/edit).
     */
    public function index()
    {
        $bidangs = BidangCu::orderBy('id')->get();
        return view('admin.bidang', compact('bidangs'));
    }

    /**
     * Simpan bidang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        BidangCu::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.bidang-cu.index')
                         ->with('success', 'Bidang CU berhasil ditambahkan.');
    }

    /**
     * Update data bidang.
     */
    public function update(Request $request, BidangCu $bidangCu)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $bidangCu->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.bidang-cu.index')
                         ->with('success', 'Bidang CU berhasil diperbarui.');
    }

    /**
     * Hapus bidang.
     */
    public function destroy(BidangCu $bidangCu)
    {
        $bidangCu->delete();

        return redirect()->route('admin.bidang-cu.index')
                         ->with('success', 'Bidang CU berhasil dihapus.');
    }
}
