<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulePiBi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulePiBiController extends Controller
{
    public function index()
    {
        $schedules = SchedulePiBi::with(['peserta.user', 'juris'])
            ->orderBy('tanggal')
            ->paginate(10);

        return view('admin.schedules', compact('schedules'));
    }

    public function create()
    {
        $pesertas = DB::table('cu_selection')
            ->where('selection_round', 1)
            ->where('status_lolos', 'lolos')
            ->distinct()
            ->pluck('peserta_id');

        $juris = User::where('role', 'juri')->pluck('name', 'id');

        $schedule = new SchedulePiBi;
        return view('admin.schedules._form', compact('schedule', 'pesertas', 'juris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peserta_id' => 'required|integer|exists:cu_selection,peserta_id',
            'juri_id'    => 'required|array|min:1',
            'juri_id.*'  => 'integer|exists:users,id',
            'tanggal'    => 'required|date',
            'lokasi'     => 'required|string|max:150',
        ]);

        // Verifikasi peserta lolos
        $ok = DB::table('cu_selection')
            ->where('peserta_id', $data['peserta_id'])
            ->where('selection_round', 1)
            ->where('status_lolos', 'lolos')
            ->exists();

        if (! $ok) {
            return back()
                ->withErrors(['peserta_id' => 'Peserta belum lolos seleksi pertama.'])
                ->withInput();
        }

        // Buat atau update header, simpan juri pertama sebagai placeholder
        $firstJuri = $data['juri_id'][0];
        $schedule = SchedulePiBi::updateOrCreate(
            ['peserta_id' => $data['peserta_id']],
            [
                'tanggal' => $data['tanggal'],
                'lokasi'  => $data['lokasi'],
                'juri_id' => $firstJuri,
            ]
        );

        // Tambahkan juri tanpa menghapus pivot lama
        $schedule->juris()->syncWithoutDetaching($data['juri_id']);

        return back()->with('success', 'Jadwal dan juri berhasil disimpan.');
    }

    public function edit(SchedulePiBi $schedule)
    {
        $pesertas = DB::table('cu_selection')
            ->where('selection_round', 1)
            ->where('status_lolos', 'lolos')
            ->distinct()
            ->pluck('peserta_id');

        $juris = User::where('role', 'juri')->pluck('name', 'id');
        $schedule->load('juris');

        return view('admin.schedules._form', compact('schedule', 'pesertas', 'juris'));
    }

    public function update(Request $request, SchedulePiBi $schedule)
    {
        $data = $request->validate([
            'juri_id'   => 'required|array|min:1',
            'juri_id.*' => 'integer|exists:users,id',
            'tanggal'   => 'required|date',
            'lokasi'    => 'required|string|max:150',
        ]);

        // Update header (placeholder juri pertama)
        $firstJuri = $data['juri_id'][0];
        $schedule->update([
            'tanggal' => $data['tanggal'],
            'lokasi'  => $data['lokasi'],
            'juri_id' => $firstJuri,
        ]);

        // Tambahkan juri baru tanpa menghapus yang lama
        $schedule->juris()->syncWithoutDetaching($data['juri_id']);

        return back()->with('success', 'Juri berhasil ditambahkan ke jadwal.');
    }

    public function destroy(SchedulePiBi $schedule)
    {
        $schedule->juris()->detach();
        $schedule->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function detail(SchedulePiBi $schedule)
    {
        $schedule->load(['peserta.user', 'juris']);
        return view('admin.schedules._detail', compact('schedule'));
    }
}
