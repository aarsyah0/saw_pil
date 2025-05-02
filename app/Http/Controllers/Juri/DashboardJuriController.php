<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardJuriController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\JuriMiddleware::class);
    }

    public function index()
    {
        return view('juri.dashboard'); // Pastikan view ini ada
    }
}
