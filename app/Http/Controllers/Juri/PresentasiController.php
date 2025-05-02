<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresentasiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Alternatif',
            'categories' => [
                ['id' => 1, 'name' => 'Ahmad', 'pi' => '!', 'bi' => '!']
            ]
        ];
        
        return view('juri.presentasi', $data);
    }
}
