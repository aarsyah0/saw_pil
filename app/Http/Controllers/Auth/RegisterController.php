<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tempat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_handphone' => 'required|string|max:15',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
        ]);

        // Handle file upload if present
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('mahasiswa-photos', 'public');
        }

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            // Create mahasiswa profile
            Mahasiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nim' => $request->nim,
                'tempat_lahir' => $request->tempat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_handphone' => $request->no_handphone,
                'email' => $request->email,
                'jurusan' => $request->jurusan,
                'prodi' => $request->prodi,
                'foto' => $fotoPath,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please login with your credentials.');
    }
}