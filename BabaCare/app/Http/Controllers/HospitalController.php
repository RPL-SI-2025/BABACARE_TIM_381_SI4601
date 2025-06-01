<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        $query = Hospital::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_rumah_sakit', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_rumah_sakit', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_staff', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $sortField = $request->input('sort', 'nama_rumah_sakit');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $hospitals = $query->paginate(10);

        return view('hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_rumah_sakit' => 'required|unique:hospitals,nama_rumah_sakit|max:255',
            'kode_rumah_sakit' => 'required|unique:hospitals,kode_rumah_sakit|max:50',
            'nama_staff' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tipe' => 'required|in:Pemerintah,Swasta,Khusus,Akademik,Lainnya',
            'deskripsi' => 'nullable|string',
            'is_rujukan' => 'boolean'
        ]);

        $hospital = Hospital::create($validatedData);

        return redirect()->route('hospitals.index')
            ->with('success', 'Rumah Sakit berhasil ditambahkan');
    }

    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $validatedData = $request->validate([
            'nama_rumah_sakit' => 'required|unique:hospitals,nama_rumah_sakit,' . $hospital->id . '|max:255',
            'kode_rumah_sakit' => 'required|unique:hospitals,kode_rumah_sakit,' . $hospital->id . '|max:50',
            'nama_staff' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tipe' => 'required|in:Pemerintah,Swasta,Khusus,Akademik,Lainnya',
            'deskripsi' => 'nullable|string',
            'is_rujukan' => 'boolean'
        ]);

        $hospital->update($validatedData);

        return redirect()->route('hospitals.index')
            ->with('success', 'Rumah Sakit berhasil diperbarui');
    }

    public function destroy(Hospital $hospital)
    {
        try {
            $hospital->delete();
            return redirect()->route('hospitals.index')
                ->with('success', 'Rumah Sakit berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('hospitals.index')
                ->with('error', 'Tidak dapat menghapus Rumah Sakit yang sudah memiliki referensi');
        }
    }

    public function getOptions(Request $request)
    {
        $hospitals = Hospital::rujukan()
            ->when($request->has('search'), function($query) use ($request) {
                $query->where('nama_rumah_sakit', 'like', '%' . $request->search . '%');
            })
            ->get(['id', 'nama_rumah_sakit']);

        return response()->json($hospitals);
    }
}