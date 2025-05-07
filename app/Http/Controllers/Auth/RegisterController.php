<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'name'               => 'required|string|max:100',
            'email'              => 'required|string|email|max:100|unique:users,email',
            'password'           => 'required|string|min:8|confirmed',
            'nik'                => 'required|string|max:20',
            'tempat_lahir'       => 'required|string|max:50',
            'tanggal_lahir'      => 'required|date',
            'nim'                => 'required|string|max:20|unique:peserta_profile,nim',
            'no_hp'              => 'required|string|max:20',
            'program_pendidikan' => 'required|in:Diploma3,Diploma4',
            'program_studi'      => 'required|string|max:100',
            'semester_ke'        => 'required|integer|min:1',
            'ipk'                => 'required|numeric|min:0|max:4',
            'kode_pt'            => 'required|string|max:10',
            'wilayah_lldikti'    => 'required|string|max:50',
            'perguruan_tinggi'   => 'required|string|max:150',
            'alamat_pt'          => 'required|string',
            'telp_pt'            => 'required|string|max:20',
            'email_pt'           => 'required|string|email|max:100',
            'pas_foto'           => 'required|image|max:2048',
            'surat_pengantar'    => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Simpan file lebih dulu
        $fotoPath  = $request->file('pas_foto')->store('peserta/foto', 'public');
        $suratPath = $request->file('surat_pengantar')->store('peserta/surat', 'public');

        DB::beginTransaction();
        try {
            // 1. Buat User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'peserta',
            ]);

            // 2. Buat PesertaProfile VIA relasi, user_id otomatis terisi
            $user->pesertaProfile()->create([
                'nik'                => $request->nik,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'nim'                => $request->nim,
                'no_hp'              => $request->no_hp,
                'program_pendidikan' => $request->program_pendidikan,
                'program_studi'      => $request->program_studi,
                'semester_ke'        => $request->semester_ke,
                'ipk'                => $request->ipk,
                'kode_pt'            => $request->kode_pt,
                'wilayah_lldikti'    => $request->wilayah_lldikti,
                'perguruan_tinggi'   => $request->perguruan_tinggi,
                'alamat_pt'          => $request->alamat_pt,
                'telp_pt'            => $request->telp_pt,
                'email_pt'           => $request->email_pt,
                'pas_foto'           => $fotoPath,
                'surat_pengantar'    => $suratPath,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Pendaftaran gagal: ' . $e->getMessage()]);
        }

        return redirect()->route('login')
                         ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
