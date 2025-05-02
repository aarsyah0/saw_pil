<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function update(Request $request)
{
    $user = Auth::user(); // Pastikan ini mengembalikan instance User

    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'nim' => 'required|string|max:20',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'jurusan' => 'required|string|max:255',
    ]);

    // Pastikan $user adalah instance dari User
    if ($user instanceof User) {
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'nim' => $request->nim,
            'phone' => $request->phone,
            'email' => $request->email,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    return redirect()->route('user.profile')->with('error', 'User not found.');
}

}
