<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchUserController extends Controller
{
    public function showSwitchForm()
    {
        return view('auth.switch');
    }

    public function switchUser(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,dokter,pasien'
        ]);

        $user = Auth::user();
        $user->role = $request->role;
        $user->save();

        return redirect()->route('home')->with('success', 'Role berhasil diubah menjadi ' . ucfirst($request->role));
    }
} 