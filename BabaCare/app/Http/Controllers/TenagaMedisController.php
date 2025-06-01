<?php

namespace App\Http\Controllers;

use App\Models\TenagaMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenagaMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenagaMedis = TenagaMedis::latest()->get();
        return view('tenaga_medis.index', compact('tenagaMedis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenaga_medis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:tenaga_medis,email',
            'password' => 'required|min:6',
        ]);

        // Set role petugas secara default
        $validated['role'] = 'petugas';
        $validated['password'] = Hash::make($validated['password']);

        TenagaMedis::create($validated);

        return redirect()
            ->route('tenaga_medis.index')
            ->with('success', 'Data tenaga medis berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaMedis $tenagaMedis)
    {
        return view('tenaga_medis.view', compact('tenagaMedis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaMedis $tenagaMedis)
    {
        return view('tenaga_medis.edit', compact('tenagaMedis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaMedis $tenagaMedis)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:tenaga_medis,email,' . $tenagaMedis->id,
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['role'] = 'petugas';
        
        $tenagaMedis->update($validated);

        return redirect()
            ->route('tenaga_medis.index')
            ->with('success', 'Data tenaga medis berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaMedis $tenagaMedis)
    {
        try {
            $tenagaMedis->delete();
            
            return redirect()
                ->route('tenaga_medis.index')
                ->with('success', 'Data tenaga medis berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('tenaga_medis.index')
                ->with('error', 'Gagal menghapus data tenaga medis.');
        }
    }
}
