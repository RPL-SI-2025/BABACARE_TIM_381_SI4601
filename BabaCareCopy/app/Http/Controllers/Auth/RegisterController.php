<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register_page'); // Pastikan nama view sesuai
    }

    public function register(Request $request)
    {
        // Tambahkan logika registrasi di sini
    }
}
