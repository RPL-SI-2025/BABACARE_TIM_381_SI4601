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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'visit_history' => 'nullable|string|max:1000',
            'disease_history' => 'nullable|string|max:1000',
            'allergy' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:penggunas,email,' . $user->id,
        ]);

        $user->update($request->only([
            'first_name',
            'last_name',
            'age',
            'birth_date',
            'phone',
            'address',
            'visit_history',
            'disease_history',
            'allergy',
            'email',
        ]));

        // Update name field based on first_name and last_name
        if ($request->first_name || $request->last_name) {
            $user->name = trim($request->first_name . ' ' . $request->last_name);
            $user->save();
        }

        return redirect()->route('user.landing')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
