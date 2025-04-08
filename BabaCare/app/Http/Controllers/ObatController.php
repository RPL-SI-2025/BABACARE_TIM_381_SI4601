<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Tampilkan semua data obat.
     */
    public function index()
    {
        $obats = Obat::all();
        return view('obat.index', compact('obats'));
    }

    /**
     * Tampilkan form tambah obat.
     */
    public function create()
    {
        return view('obat.create');
    }

    /**
     * Simpan data obat baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        Obat::create($request->all());
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail obat.
     */
    public function show(Obat $obat)
    {
        return view('obat.show', compact('obat'));
    }

    /**
     * Tampilkan form edit obat.
     */
    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    /**
     * Simpan perubahan data obat.
     */
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $obat->update($request->all());
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Hapus data obat.
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }

    // public function index(Request $request)
    // {
    //     $search = $request->query('search');
    //     $obats = Obat::when($search, function($query, $search) {
    //         return $query->where('nama', 'like', "%$search%");
    //     })->paginate(10);

    //     return view('obat.index', compact('obats'));
    // }

}
