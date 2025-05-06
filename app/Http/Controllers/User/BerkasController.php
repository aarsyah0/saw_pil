<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CuSubmission;
use App\Models\KategoriCu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function __construct()
    {
        // Hanya peserta yang bisa mengakses
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar submission milik peserta.
     */
    public function index()
    {
        $submissions = CuSubmission::where('peserta_id', Auth::id())
                                   ->orderBy('submitted_at', 'desc')
                                   ->get();
        $kategoris = KategoriCu::all();

        return view('user.berkas', compact('submissions', 'kategoris'));
    }

    /**
     * Tampilkan form unggah CU.
     */
    public function create()
    {
        $kategoris = KategoriCu::all();
        return view('berkas.create', compact('kategoris'));
    }

    /**
     * Proses unggah dan simpan record baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_cu_id' => 'required|exists:kategori_cu,id',
            'file'           => 'required|file|mimes:pdf,zip|max:10240', // 10MB
        ]);

        // Ambil skor default dari kategori
        $kategori    = KategoriCu::findOrFail($data['kategori_cu_id']);
        $defaultSkor = $kategori->skor;

        // Simpan file di storage/app/public/cu_submissions
        $path = $request->file('file')->store('cu_submissions', 'public');

        CuSubmission::create([
            'peserta_id'     => Auth::id(),
            'kategori_cu_id' => $data['kategori_cu_id'],
            'file_path'      => $path,
            'status'         => 'pending',
            'skor'           => $defaultSkor,
        ]);

        return redirect()->route('berkas.index')
                         ->with('success', "Berkas berhasil diunggah (skor default: {$defaultSkor}) dan menunggu review.");
    }

    /**
     * Unduh berkas CU peserta.
     */
    public function show(CuSubmission $berkas)
    {
    // Cek apakah user yang login adalah pemilik berkas
    if (auth()->user()->peserta && auth()->user()->peserta->id !== $berkas->peserta_id) {
        abort(403, 'Anda tidak diizinkan mengakses berkas ini.');
    }

    // Cek apakah file benar-benar ada
    if (!Storage::disk('public')->exists($berkas->file_path)) {
        abort(404, 'File tidak ditemukan.');
    }

    // Unduh file
    return Storage::disk('public')->download($berkas->file_path);
    }


    /**
     * Hapus berkas CU jika masih pending.
     */
    public function destroy(CuSubmission $berkas)
{
    // Hapus file jika ada
    if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
        Storage::disk('public')->delete($berkas->file_path);
    }

    // Hapus record
    $berkas->delete();

    return back()->with('success', 'Berkas berhasil dihapus.');
}

}
