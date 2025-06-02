<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PesertaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProfileController extends Controller
{
    /**
     * Tampilkan form:
     * - jika file belum diunggah, tampilkan langkah 1 (upload)
     * - selalu tampilkan form data
     */
    public function form()
    {
        $user    = Auth::user();
        $profile = $user->pesertaProfile ?: new PesertaProfile(['user_id' => $user->id]);
        return view('user.profile', compact('user','profile'));
    }

    /**
     * Langkah 1: upload pas_foto & surat_pengantar via POST
     */
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'pas_foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'surat_pengantar' => 'nullable|mimes:pdf|max:5120',
        ]);


        $user    = Auth::user();
        $profile = $user->pesertaProfile ?: new PesertaProfile(['user_id' => $user->id]);

        // Buat direktori jika belum ada
        Storage::disk('public')->makeDirectory('photos', 0755, true);
        Storage::disk('public')->makeDirectory('letters', 0755, true);

        // Simpan foto
        if ($file = $request->file('pas_foto')) {
            if ($profile->pas_foto) {
                Storage::disk('public')->delete($profile->pas_foto);
            }
            $profile->pas_foto = $file->store('photos', 'public');
        }

        // Simpan surat
        if ($file = $request->file('surat_pengantar')) {
            if ($profile->surat_pengantar) {
                Storage::disk('public')->delete($profile->surat_pengantar);
            }
            $profile->surat_pengantar = $file->store('letters', 'public');
        }

        $profile->save();

        return redirect()
            ->route('user.profile.form')
            ->with('success', 'File berhasil diunggah. Silakan lengkapi data berikutnya.');
    }

    /**
     * Langkah 2: simpan data teks profil via POST
     */
    public function save(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'               => 'required|string|max:100',
            'email'              => 'required|email|max:100|unique:users,email,' . $user->id,
            'password'           => 'nullable|confirmed|min:6',
            'nik'                => 'required|string|size:16',
            'nim'                => 'required|string|max:20',
            'no_hp'              => 'required|string|max:20',
            'tempat_lahir'       => 'required|string|max:50',
            'tanggal_lahir'      => 'required|date',
            'program_pendidikan' => 'required|in:Diploma,Sarjana,Diploma3,Diploma4',
            'jurusan'            => 'required|string|max:100',
            'program_studi'      => 'required|string|max:100',
            'semester_ke'        => 'required|integer|min:1',
            'ipk'                => 'required|numeric|between:0,4',
        ];
        $data = $request->validate($rules);

        try {
            // Update user
            $user->name  = $data['name'];
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();

            // Fill profil
            $profile = $user->pesertaProfile ?: new PesertaProfile(['user_id' => $user->id]);
            $profile->fill($data);
            $profile->save();

            return redirect()
                ->route('user.profile.form')
                ->with('success', 'Profil berhasil diperbarui.');
        }
        catch (Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()]);
        }
    }
}
