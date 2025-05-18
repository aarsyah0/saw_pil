<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulePiBi;
use App\Models\User;
use App\Models\JuriProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchedulePiBiController extends Controller
{
    public function index()
    {
        $schedules = SchedulePiBi::with(['peserta', 'juris'])
            ->orderBy('tanggal')
            ->paginate(10);

        $scheduledIds = SchedulePiBi::pluck('peserta_id')->toArray();

        $pesertas = User::whereHas('pesertaProfile', fn($q) =>
                $q->whereHas('cuSelection', fn($q2) =>
                    $q2->where('selection_round', 1)
                       ->where('status_lolos', 'lolos')
                )
            )
            ->whereNotIn('id', $scheduledIds)
            ->pluck('name', 'id');

        $juris = User::where('role', 'juri')->pluck('name', 'id');

        return view('admin.schedules', compact('schedules', 'pesertas', 'juris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peserta_id' => 'required|exists:users,id',
            'juri_id'    => 'required|array|min:1',
            'juri_id.*'  => 'exists:users,id',
            'tanggal'    => 'required|date_format:Y-m-d\TH:i',
            'lokasi'     => 'required|string|max:150',
        ]);

        // Pastikan setiap juri punya profile di juri_profile
        foreach ($data['juri_id'] as $jId) {
            JuriProfile::firstOrCreate(['user_id' => $jId]);
        }

        $dt = Carbon::createFromFormat('Y-m-d\TH:i', $data['tanggal'])
                    ->toDateTimeString();

        if (SchedulePiBi::where('peserta_id', $data['peserta_id'])->exists()) {
            return back()
                ->withErrors(['peserta_id' => 'Peserta sudah memiliki jadwal.'])
                ->withInput();
        }

        // Simpan jadwal baru, dengan juri utama dari elemen pertama
        $schedule = SchedulePiBi::create([
            'peserta_id' => $data['peserta_id'],
            'juri_id'    => $data['juri_id'][0],
            'tanggal'    => $dt,
            'lokasi'     => $data['lokasi'],
        ]);

        // Attach semua juri ke pivot
        $schedule->juris()->attach($data['juri_id']);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal dan juri berhasil disimpan.');
    }

    public function update(Request $request, $id)
{
    $data = $request->validate([
        'juri_id'   => 'required|array|min:1',
        'juri_id.*' => 'exists:users,id',
        'tanggal'   => 'required|date_format:Y-m-d\TH:i',
        'lokasi'    => 'required|string|max:150',
    ]);

    // Pastikan profile juri ada
    foreach ($data['juri_id'] as $jId) {
        JuriProfile::firstOrCreate(['user_id' => $jId]);
    }

    $dt = Carbon::createFromFormat('Y-m-d\TH:i', $data['tanggal'])
                ->toDateTimeString();

    $schedule = SchedulePiBi::findOrFail($id);

    // (Opsional) Jangan ubah kolom juri_id utama,
    // atau set ke juri pertama jika Anda mau:
    // $schedule->juri_id = $data['juri_id'][0];

    $schedule->update([
        // jika Anda ingin juri utama berganti:
        // 'juri_id' => $data['juri_id'][0],
        'tanggal' => $dt,
        'lokasi'  => $data['lokasi'],
    ]);

    // Hanya tambahkan juri baru, tanpa menghapus yang lama:
    $schedule->juris()->syncWithoutDetaching($data['juri_id']);

    return redirect()
        ->route('admin.schedules.index')
        ->with('success', 'Jadwal diperbarui dan juri tambahan berhasil ditambahkan.');
}


    public function destroy($id)
    {
        $schedule = SchedulePiBi::findOrFail($id);
        // Detach semua juri di pivot
        $schedule->juris()->detach();
        $schedule->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function detail($id)
    {
        $schedule = SchedulePiBi::with(['peserta', 'juris'])->findOrFail($id);
        return view('admin.schedules._detail', compact('schedule'));
    }
}
