<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;

class BobotKriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman index (dengan modal Tambah/Edit).
     */
    public function index()
    {
        // Ambil semua data
        $items = BobotKriteria::all();
        // Pastikan nama view sesuai: resources/views/admin/bobot-kriteria/index.blade.php
        return view('admin.bobot', compact('items'));
    }

    /**
     * Simpan bobot baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|in:CU,PI,BI|unique:bobot_kriteria,nama_kriteria',
            'bobot'         => 'required|numeric|between:0,1',
        ]);

        BobotKriteria::create($request->only('nama_kriteria','bobot'));

        return redirect()
            ->route('admin.bobot-kriteria.index')
            ->with('success', 'Bobot kriteria berhasil ditambahkan.');
    }

    /**
     * Update bobot (dipanggil via PUT dari modal).
     */
    public function update(Request $request, $nama)
    {
        $request->validate([
            'bobot' => 'required|numeric|between:0,1',
        ]);

        $item = BobotKriteria::findOrFail($nama);
        $item->update(['bobot' => $request->bobot]);

        return redirect()
            ->route('admin.bobot-kriteria.index')
            ->with('success', 'Bobot kriteria berhasil diperbarui.');
    }
}
