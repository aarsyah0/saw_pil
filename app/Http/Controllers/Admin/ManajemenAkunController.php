<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Hash;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        // eager load semua profile agar tidak N+1
        $users = User::with(['adminProfile','juriProfile','pesertaProfile'])
                     ->orderBy('role')
                     ->orderBy('name')
                     ->paginate(15);

        return view('admin.manajemenakun.index', compact('users'));
    }

    public function create()
    {
        return view('admin.manajemenakun.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role'     => ['required', Rule::in(['admin','juri','peserta'])],
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        // (Opsional) Buat record profile kosong sesuai role
        // misal: AdminProfile::create(['user_id'=>$user->id]);

        return redirect()->route('admin.manajemen-akun.index')
                         ->with('success','Akun berhasil dibuat.');
    }

    public function edit(User $manajemenAkun)
    {
        return view('admin.manajemenakun.edit', [
            'user' => $manajemenAkun
        ]);
    }

    public function update(Request $request, User $manajemenAkun)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => ['required','email', Rule::unique('users')->ignore($manajemenAkun->id)],
            'password' => 'nullable|confirmed|min:6',
            'role'  => ['required', Rule::in(['admin','juri','peserta'])],
        ]);

        if ($data['password'] ?? false) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $manajemenAkun->update($data);

        return redirect()->route('admin.manajemen-akun.index')
                         ->with('success','Akun berhasil diperbarui.');
    }

    public function destroy(User $manajemenAkun)
    {
        $manajemenAkun->delete();
        return back()->with('success','Akun berhasil dihapus.');
    }
}
