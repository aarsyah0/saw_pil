<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CuSubmission;
use App\Models\PenilaianAkhir;

class DashboardController extends Controller
{
    public function index()
    {
        // Total peserta
        $totalPeserta = User::where('role', 'peserta')->count();

        // Total berkas (all submissions)
        $totalBerkas = CuSubmission::count();

        // Pending berkas count
        $pendingBerkas = CuSubmission::where('status', 'pending')->count();

        // Latest 5 submissions with peserta relation
        $latestSubmissions = CuSubmission::with('peserta.user')
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();

        // Top 3 winners by final total score (hanya yang sudah memiliki skor PI & BI)
        $winners = PenilaianAkhir::with('peserta.user')
    // hanya yang skor PI > 0
    ->where('skor_pi_normal', '>', 0)
    // dan skor BI > 0
    ->where('skor_bi_normal', '>', 0)
    ->orderBy('total_akhir', 'desc')
    ->take(3)
    ->get();
        return view('admin.dashboard', compact(
            'totalPeserta',
            'totalBerkas',
            'pendingBerkas',
            'latestSubmissions',
            'winners'
        ));
    }
     public function destroySubmission($id)
    {
        $submission = CuSubmission::findOrFail($id);
        $submission->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Berkas CU berhasil dihapus.');
    }
}
