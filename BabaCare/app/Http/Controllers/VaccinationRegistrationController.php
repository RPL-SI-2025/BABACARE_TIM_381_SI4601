<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\VaccinationRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VaccinationRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->create();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vaccines = Vaccine::where('is_active', true)->get();
        return view('vaccination.create', compact('vaccines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks.',
                'date' => ':attribute harus berupa tanggal yang valid.',
                'after_or_equal' => ':attribute harus lebih besar atau sama dengan :date.',
                'in' => ':attribute yang dipilih tidak valid.',
            ];

            $validated = $request->validate([
                'vaccine_id' => 'required|exists:vaccines,id',
                'type' => 'required|in:vaccine, immunization',
                'vaccination_date' => 'required|date|after_or_equal:today',
                'vaccination_time' => 'required',
                'allergies' => 'nullable|string',
            ], $messages, [
                'type' => 'Kategori',
                'vaccine_id' => 'Jenis Vaksin',
                'vaccination_time' => 'Waktu Vaksin',
                'allergies' => 'Alergi',
            ]);

            $validated['pengguna_id'] = Auth::id();
            $vaccination = VaccinationRegistration::create([
                'pengguna_id' => Auth::id(),
                'vaccine_id' => $validated['vaccine_id'],
                'type' => $validated['type'],
                'vaccination_date' => $validated['vaccination_date'],
                'vaccination_time' => $validated['vaccination_time'],
                'allergies' => $validated['allergies']
            ]);

            return redirect()->route('vaccination.index')
                ->with('success', 'Pendaftaran vaksinasi berhasil dibuat.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi data.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(VaccinationRegistration $vaccination)
    // {
    //     // Authorization check
    //     $this->authorize('view', $vaccination);

    //     return view('vaccination.show', compact('vaccination'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(VaccinationRegistration $vaccination)
    // {
    //     // Authorization check
    //     $this->authorize('update', $vaccination);

    //     $vaccines = Vaccine::where('is_active', true)->get();
        
    //     return view('vaccination.edit', compact('vaccination', 'vaccines'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, VaccinationRegistration $vaccination)
    // {
    //     // Authorization check
    //     $this->authorize('update', $vaccination);

    //     $validated = $request->validate([
    //         'vaccine_id' => 'required|exists:vaccines,id',
    //         'type' => 'required|in:vaccine, immunization',
    //         'patient_name' => 'required|string|max:255',
    //         'vaccination_date' => 'required|date',
    //         'vaccination_time' => 'required',
    //         'allergies' => 'nullable|string',
    //     ]);

    //     $vaccination->update($validated);

    //     return redirect()->route('vaccination.index')
    //         ->with('success', 'Pendaftaran vaksinasi berhasil diperbarui.');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(VaccinationRegistration $vaccination)
    // {
    //     // Authorization check
    //     $this->authorize('delete', $vaccination);

    //     $vaccination->delete();

    //     return redirect()->route('vaccination.index')
    //         ->with('success', 'Pendaftaran vaksinasi berhasil dihapus.');
    // }
}