<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelCu;
use Illuminate\Http\Request;

class LevelCuController extends Controller
{
    /**
     * Tampilkan daftar level.
     */
    public function index()
    {
        $levels = LevelCu::orderBy('level')->get();
        return view('admin.level', compact('levels'));
    }

    /**
     * Simpan level baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'level'       => 'required|string|size:1|unique:level_cu,level',
            'description' => 'required|string|max:50',
        ]);

        LevelCu::create($request->only('level','description'));

        return redirect()->route('admin.level-cu.index')
                         ->with('success','Level CU berhasil ditambahkan.');
    }

    /**
     * Update level.
     */
    public function update(Request $request, $level)
    {
        $request->validate([
            'description' => 'required|string|max:50',
        ]);

        $lc = LevelCu::findOrFail($level);
        $lc->update(['description' => $request->description]);

        return redirect()->route('admin.level-cu.index')
                         ->with('success','Level CU berhasil diperbarui.');
    }

    /**
     * Hapus level.
     */
    public function destroy($level)
    {
        LevelCu::findOrFail($level)->delete();

        return redirect()->route('admin.level-cu.index')
                         ->with('success','Level CU berhasil dihapus.');
    }
}
