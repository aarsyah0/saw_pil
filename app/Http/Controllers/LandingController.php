<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Purpose;
use App\Models\Requirement;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Tampilkan halaman landing dengan data dynamic.
     */
    public function index()
    {

        // ambil data sesuai urutan
        $heroSlides   = HeroSlide::with('features')->orderBy('order')->get();
        $purposes     = Purpose::orderBy('order')->get();
        $requirements = Requirement::orderBy('order')->get();
        $schedules    = Schedule::orderBy('order')->get();

        // lempar ke view
        return view('landing', compact(
            'heroSlides',
            'purposes',
            'requirements',
            'schedules'
        ));
    }
}
