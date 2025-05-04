<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulePiBi;
use App\Models\User;
use Illuminate\Http\Request;

class SchedulePiBiController extends Controller
{
    /**
     * Display a paginated list of schedules with eager-loaded peserta and juries,
     * and only include participants who don’t yet have a schedule in the "add" modal.
     */
    public function index()
    {
        // All schedules for listing
        $schedules = SchedulePiBi::with(['peserta', 'juris'])
            ->orderBy('tanggal')
            ->paginate(10);

        // IDs of peserta already scheduled
        $scheduledIds = SchedulePiBi::pluck('peserta_id')->toArray();

        // Only peserta who passed selection AND are not yet scheduled
        $pesertas = User::whereHas('pesertaProfile', function($q) {
                $q->whereHas('cuSelection', function($q2) {
                    $q2->where('selection_round', 1)
                       ->where('status_lolos', 'lolos');
                });
            })
            ->whereNotIn('id', $scheduledIds)
            ->pluck('name', 'id');

        $juris = User::where('role', 'juri')->pluck('name', 'id');

        return view('admin.schedules', compact('schedules', 'pesertas', 'juris'));
    }

    /**
     * Store a new schedule and its juries.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'peserta_id' => 'required|exists:users,id',
            'juri_id'    => 'required|array|min:1',
            'juri_id.*'  => 'exists:users,id',
            'tanggal'    => 'required|date',
            'lokasi'     => 'required|string|max:150',
        ]);

        if (SchedulePiBi::where('peserta_id', $data['peserta_id'])->exists()) {
            return back()->withErrors(['peserta_id' => 'Peserta sudah memiliki jadwal.'])->withInput();
        }

        $schedule = SchedulePiBi::create([
            'peserta_id' => $data['peserta_id'],
            'tanggal'    => $data['tanggal'],
            'lokasi'     => $data['lokasi'],
            'juri_id'    => $data['juri_id'][0],
        ]);

        $schedule->juris()->sync($data['juri_id']);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dan juri berhasil disimpan.');
    }

    /**
     * Update an existing schedule by adding new juries (multi-juri) without removing existing ones.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'juri_id'   => 'required|array|min:1',
            'juri_id.*' => 'exists:users,id',
            'tanggal'   => 'required|date',
            'lokasi'    => 'required|string|max:150',
        ]);

        $schedule = SchedulePiBi::findOrFail($id);
        $schedule->update([
            'tanggal' => $data['tanggal'],
            'lokasi'  => $data['lokasi'],
            'juri_id' => $data['juri_id'][0],
        ]);

        // Add selected juries without removing existing ones
        $schedule->juris()->syncWithoutDetaching($data['juri_id']);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dan juri berhasil diperbarui.');
    }

    /**
     * Delete a schedule and detach juries.
     */
    public function destroy($id)
    {
        $schedule = SchedulePiBi::findOrFail($id);
        $schedule->juris()->detach();
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Return HTML detail for a schedule (AJAX-loaded).
     */
    public function detail($id)
    {
        $schedule = SchedulePiBi::with(['peserta', 'juris'])->findOrFail($id);
        return view('admin.schedules._detail', compact('schedule'));
    }
}
