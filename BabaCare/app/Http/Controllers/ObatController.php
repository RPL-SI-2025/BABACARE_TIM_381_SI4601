<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Golongan;
use App\Models\Kategori;

class ObatController extends Controller
{
    // Menampilkan daftar semua obat
    public function index(Request $request)
    {
        // Eager loading untuk kategori dan golongan
        $obats = Obat::with(['kategori', 'golongan'])->get();

        // Jika ada pencarian berdasarkan nama obat
        if ($request->has('search')) {
            $obats = $obats->filter(function ($obat) use ($request) {
                return str_contains(strtolower($obat->nama_obat), strtolower($request->search));
            });
        }

        return view('obats.index', compact('obats'));
    }

    // Menampilkan form untuk menambahkan obat baru
    public function create()
    {
        $golongans = Golongan::all(); // Mengambil semua data golongan
        $kategoris = Kategori::all(); // Mengambil semua data kategori
        // Mengembalikan tampilan form pembuatan obat dengan data golongan dan kategori
        return view('obats.create', compact('golongans', 'kategoris'));
        
    }

    // Menyimpan obat baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kategori_id' => $request->kategori_id,
            'golongan_id' => $request->golongan_id,
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
        $obat = Obat::findOrFail($id);
        $kategoris = Kategori::all();
        $golongans = Golongan::all();

        return view('obats.edit', compact('obat', 'kategoris', 'golongans'));
    }

    // Memperbarui data obat di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kategori_id' => $request->kategori_id,
            'golongan_id' => $request->golongan_id,
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


    public function dashboard()
    {
        $totalObat = Obat::count(); // Menghitung total obat

        // // Menghitung jumlah per kategori dengan join ke tabel 'kategoris'
        // $jumlahPerKategori = Obat::join('kategoris', 'obats.kategori_id', '=', 'kategoris.id')
        //                             ->select('kategoris.nama_kategori', \DB::raw('count(*) as jumlah'))
        //                             ->groupBy('kategoris.nama_kategori')
        //                             ->get();

        // // Menghitung jumlah per golongan dengan join ke tabel 'golongans'
        // $jumlahPerGolongan = Obat::join('golongans', 'obats.golongan_id', '=', 'golongans.id')
        //                             ->select('golongans.nama_golongan', \DB::raw('count(*) as jumlah'))
        //                             ->groupBy('golongans.nama_golongan')
        //                             ->get();

        $jumlahPerKategori = Kategori::withCount('obats')->get();
        $jumlahPerGolongan = Golongan::withCount('obats')->get();
        // Ambil semua data obat untuk ditampilkan di dashboard
        $obats = Obat::with(['kategori', 'golongan'])->get();

        return view('obats.dashboarddataobat', compact('totalObat', 'jumlahPerKategori', 'jumlahPerGolongan', 'obats'));
    }




}
