<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        }

        $patients = $query->latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
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
                'max' => ':attribute tidak boleh lebih dari :max karakter.',
                'date' => ':attribute harus berupa tanggal yang valid.',
                'in' => ':attribute yang dipilih tidak valid.',
                'unique' => ':attribute sudah terdaftar dalam sistem.',
                'nik.unique' => 'NIK sudah terdaftar dalam sistem. Mohon periksa kembali NIK yang dimasukkan.'
            ];

            $attributes = [
                'nama_pasien' => 'Nama pasien',
                'nik' => 'NIK',
                'gender' => 'Gender',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_perawatan' => 'Jenis perawatan',
                'waktu_periksa' => 'Waktu periksa',
                'penyakit' => 'Penyakit',
                'obat' => 'Obat',
                'hasil_pemeriksaan' => 'Hasil pemeriksaan'
            ];

            $validated = $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'nik' => 'required|string|unique:patients,nik|max:16',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'required|date',
                'jenis_perawatan' => 'required|string|max:255',
                'waktu_periksa' => 'required|date',
                'penyakit' => 'required|string|max:255',
                'obat' => 'required|string|max:255',
                'hasil_pemeriksaan' => 'required|string'
            ], $messages, $attributes);

            Patient::create($validated);

            return redirect()->route('patients.index')
                ->with('success', 'Data pasien berhasil ditambahkan.');
                
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi data.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        try {
            $messages = [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks.',
                'max' => ':attribute tidak boleh lebih dari :max karakter.',
                'date' => ':attribute harus berupa tanggal yang valid.',
                'in' => ':attribute yang dipilih tidak valid.',
                'unique' => ':attribute sudah terdaftar dalam sistem.',
                'nik.unique' => 'NIK sudah terdaftar untuk pasien lain. Mohon periksa kembali NIK yang dimasukkan.'
            ];

            $attributes = [
                'nama_pasien' => 'Nama pasien',
                'nik' => 'NIK',
                'gender' => 'Gender',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_perawatan' => 'Jenis perawatan',
                'waktu_periksa' => 'Waktu periksa',
                'penyakit' => 'Penyakit',
                'obat' => 'Obat',
                'hasil_pemeriksaan' => 'Hasil pemeriksaan'
            ];

            $validated = $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'nik' => 'required|string|max:16|unique:patients,nik,' . $patient->id,
                'gender' => 'required|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'required|date',
                'jenis_perawatan' => 'required|string|max:255',
                'waktu_periksa' => 'required|date',
                'penyakit' => 'required|string|max:255',
                'obat' => 'required|string|max:255',
                'hasil_pemeriksaan' => 'required|string'
            ], $messages, $attributes);

            $patient->update($validated);

            return redirect("/patients/{$patient->id}")
                ->with('success', 'Data pasien berhasil diperbarui.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi data.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect()->route('patients.index')
                ->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
