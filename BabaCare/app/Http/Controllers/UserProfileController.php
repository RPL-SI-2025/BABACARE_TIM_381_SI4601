<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'nik' => 'nullable|string|size:16|unique:penggunas,nik,' . $user->id,
            'gender' => 'nullable|string|max:10',
            'disease_history' => 'nullable|string|max:1000',
            'allergy' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:penggunas,email,' . $user->id,
        ], [
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem.',
        ]);

        $user->update($request->only([
            'name',
            'age',
            'birth_date',
            'phone',
            'address',
            'nik',
            'gender',
            'disease_history',
            'allergy',
            'email',
        ]));

        return redirect()->route('user.landing')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
