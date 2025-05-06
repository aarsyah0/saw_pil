<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuSelection;
use App\Models\CuSubmission;
use App\Models\KategoriCu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuSelectionController extends Controller
{
    public function index()
    {
        $latest = CuSelection::select('peserta_id','status_lolos','selected_at')
    ->where('selection_round',1)
    ->orderByDesc('selected_at')
    ->toBase();

    $selections = CuSelection::select([
        'cu_selection.peserta_id',
        DB::raw('SUM(skor_cu)            AS total_skor_cu'),
        DB::raw('ROUND(SUM(skor_cu)/10,4) AS avg_skor_cu'),
        // sub‑query ambil status_lolos terbaru per peserta
        DB::raw("(SELECT cs2.status_lolos
                  FROM cu_selection cs2
                  WHERE cs2.peserta_id = cu_selection.peserta_id
                    AND cs2.selection_round = 1
                  ORDER BY cs2.selected_at DESC
                  LIMIT 1) AS status_lolos"),
        // sub‑query ambil selected_at terbaru per peserta
        DB::raw("(SELECT cs3.selected_at
                  FROM cu_selection cs3
                  WHERE cs3.peserta_id = cu_selection.peserta_id
                    AND cs3.selection_round = 1
                  ORDER BY cs3.selected_at DESC
                  LIMIT 1) AS selected_at"),
    ])
    ->where('cu_selection.selection_round', 1)
    ->groupBy('cu_selection.peserta_id')
    ->with('peserta.user')
    ->orderByDesc('avg_skor_cu')
    ->get();


        return view('admin.selection', compact('selections'));
    }

    public function showDetail($pesertaId)
    {
        // 1) Semua CU approved peserta ini
        $approved = CuSubmission::with('kategori.bidang')
            ->where('peserta_id',$pesertaId)
            ->where('status', CuSubmission::STATUS_APPROVED)
            ->get();

        // 2) Group per bidang & pilih top-4 per bidang
        $byBidang = $approved->groupBy(fn($i)=> $i->kategori->bidang_id);
        $pool = collect();
        foreach($byBidang as $group){
            $pool = $pool->merge($group->sortByDesc('skor')->take(4));
        }

        // 3) Top-10 overall
        $finalSelectedCUs = $pool->sortByDesc('skor')->take(10);

        // 4) Hitung skor total & maksimal
        $totalSkorCU = $finalSelectedCUs->sum('skor');
        $maxPerBidang = KategoriCu::groupBy('bidang_id')
            ->select('bidang_id', DB::raw('MAX(skor) AS max_skor'))
            ->get()->pluck('max_skor','bidang_id');

        $maxSkorCU = 0;
        foreach($maxPerBidang as $bidangId=>$max){
            $count = $byBidang->has($bidangId)
                ? min(4,$byBidang[$bidangId]->count())
                : 0;
            $maxSkorCU += $max * $count;
        }

        $norm = $maxSkorCU>0 ? $totalSkorCU/$maxSkorCU : 0;

        // AJAX partial
        if(request()->ajax()){
            return view('admin.layouts.partials.selection_detail', compact(
                'finalSelectedCUs','totalSkorCU','maxSkorCU','norm'
            ));
        }

        // fallback redirect
        return redirect()->route('admin.cu_selection.index');
    }

    public function updateStatus(Request $request, $pesertaId)
    {
        $request->validate(['status_lolos'=>'required|in:lolos,gagal']);
        CuSelection::where('peserta_id',$pesertaId)
            ->where('selection_round',1)
            ->update([
                'status_lolos'=>$request->status_lolos,
                'selected_at'=>now(),
            ]);
        return back()->with('success','Status peserta berhasil diperbarui.');
    }
}
