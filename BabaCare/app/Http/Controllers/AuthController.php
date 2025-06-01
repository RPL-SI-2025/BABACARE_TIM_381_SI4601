<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\TenagaMedis;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login_page');
    }

    public function showRegisterForm()
    {
        return view('register_page'); 
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Ambil email dan password
        $email = $request->email;
        $password = $request->password;

        // Cek apakah email ada di penggunas
        $user = \App\Models\pengguna::where('email', $email)->first();
        if ($user) {
            // Hanya admin dan user yang bisa login dari penggunas
            if (in_array($user->role, ['admin', 'user'])) {
                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $successMessage = 'Berhasil login sebagai ' . ucfirst($user->role) . '!';
                    if ($user->role === 'admin') {
                        return redirect()->route('admin.landing')->with('success', $successMessage);
                    } else {
                        return redirect()->route('user.landing')->with('success', $successMessage);
                    }
                } else {
                    return back()->withErrors(['email' => 'Email atau password salah.'])->with('error', 'Login gagal! Email atau password salah.');
                }
            } else if ($user->role === 'petugas') {
                // Petugas tidak boleh login dari penggunas, harus dari tenaga_medis
                return back()->withErrors(['email' => 'Petugas hanya dapat login jika terdaftar di tenaga medis.'])->with('error', 'Login gagal! Petugas hanya dapat login jika terdaftar di tenaga medis.');
            } else {
                // Role tidak dikenali
                return back()->withErrors(['email' => 'Role tidak dikenali.'])->with('error', 'Login gagal! Role tidak dikenali.');
            }
        } else {
            // Jika tidak ada di penggunas, cek tenaga medis
            $petugas = \App\Models\TenagaMedis::where('email', $email)->first();
            if ($petugas && \Illuminate\Support\Facades\Hash::check($password, $petugas->password)) {
                // Simpan data ke session
                $request->session()->put('petugas', $petugas);
                $successMessage = 'Berhasil login sebagai Petugas!';
                return redirect()->route('petugas.landing')->with('success', $successMessage);
            } else {
                return back()->withErrors(['email' => 'Email atau password salah.'])->with('error', 'Login gagal! Email atau password salah.');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}