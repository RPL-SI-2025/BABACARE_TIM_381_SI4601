<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    // Menampilkan daftar semua obat
    public function index()
    {
        $obats = Obat::all(); // Mengambil semua data obat
        return view('obats.index', compact('obats')); // Mengembalikan tampilan dengan data obat
    }

    // Menampilkan form untuk menambahkan obat baru
    public function create()
    {
        return view('obats.create'); // Mengembalikan tampilan form pembuatan obat
    }

    // Menyimpan obat baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            'golongan' => ['required', 'regex:/^[A-Za-z\s]+$/'],
        ]);

        // Membuat obat baru
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kategori' => $request->kategori,
            'golongan' => $request->golongan,
        ]);

        
        return redirect()->route('obats.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    // Menampilkan detail obat berdasarkan ID
    public function show($id)
    {
        $obat = Obat::findOrFail($id); // Mencari obat berdasarkan ID
        return view('obats.show', compact('obat')); // Mengembalikan tampilan detail
    }

    // Menampilkan form edit obat
    public function edit($id)
    {
        $obat = Obat::findOrFail($id); // Mencari obat berdasarkan ID
        return view('obats.edit', compact('obat')); // Mengembalikan tampilan edit
    }

    // Memperbarui data obat di database
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'golongan' => 'required|string|min:0',
            
        ]);

        $obat = Obat::findOrFail($id); // Mencari obat berdasarkan ID
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'golongan' => $request->golongan,
            'kategori' => $request->kategori,
            
        ]);

        return redirect()->route('obats.index')->with('success', 'Obat berhasil diperbarui.');
    }

    // Menghapus data obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id); // Mencari obat berdasarkan ID
        $obat->delete(); // Menghapus obat

        return redirect()->route('obats.index')->with('success', 'Obat berhasil dihapus.');
    }
}
