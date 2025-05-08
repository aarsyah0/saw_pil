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
        return view('user.berkas_create', compact('kategoris'));
    }

    /**
     * Proses unggah dan simpan record baru.
     */
    public function store(Request $request)
    {
        // Pastikan pesertaProfile sudah ada
        if (! Auth::user()->pesertaProfile) {
            return redirect()->route('profile.create')
                             ->with('error', 'Lengkapi profil Anda terlebih dahulu sebelum mengunggah CU.');
        }

        $data = $request->validate([
            'kategori_cu_id' => 'required|exists:kategori_cu,id',
            'file'           => 'required|file|mimes:pdf,zip|max:10240', // 10MB
        ]);

        // Ambil skor default dari kategori
        $kategori    = KategoriCu::findOrFail($data['kategori_cu_id']);
        $defaultSkor = $kategori->skor;

        // Simpan file di storage/app/public/cu_submissions
        $path = $request->file('file')->store('cu_submissions', 'public');

        // Simpan submission CU
        CuSubmission::create([
            'peserta_id'     => Auth::id(),
            'kategori_cu_id' => $data['kategori_cu_id'],
            'file_path'      => $path,
            'status'         => CuSubmission::STATUS_PENDING,
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
        // Cek apakah pemilik berkas
        if (Auth::id() !== $berkas->peserta_id) {
            abort(403, 'Anda tidak diizinkan mengakses berkas ini.');
        }

        // Cek apakah file ada
        if (! Storage::disk('public')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($berkas->file_path);
    }

    /**
     * Hapus berkas CU jika masih pending dan milik peserta.
     */
    public function destroy(CuSubmission $berkas)
{
    // Cek status: hanya yang pending atau rejected yang boleh dihapus
    if ($berkas->status === CuSubmission::STATUS_APPROVED) {
        return back()->with('error', 'Berkas yang sudah disetujui tidak bisa dihapus.');
    }

    // Hapus file fisik jika ada
    if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
        Storage::disk('public')->delete($berkas->file_path);
    }

    // Hapus record dari database
    $berkas->delete();

    return back()->with('success', 'Berkas berhasil dihapus.');
}




}
