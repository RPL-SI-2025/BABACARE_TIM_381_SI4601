<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user() ?? new User();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user() ?? new User();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($user->id ?? 0),
            'whatsapp_number' => 'required|string|max:20',
            'age' => 'required|integer|min:0|max:120',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'allergies' => 'nullable|string',
            'visit_history' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'current_password' => 'nullable|string|min:8',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->age = $request->age;
        $user->date_of_birth = $request->date_of_birth;
        $user->address = $request->address;
        $user->allergies = $request->allergies;
        $user->visit_history = $request->visit_history;
        $user->medical_history = $request->medical_history;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
        }

        $user->save();

        return redirect()->route('user.profile.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }
} 