<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Obat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::with(['pengguna', 'appointment', 'obat']);

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
        $appointments = Appointment::whereDoesntHave('patient')
            ->with('pengguna')
            ->get();
        $obats = Obat::all();
        return view('patients.create', compact('appointments', 'obats'));
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
                'address' => 'Alamat',
                'allergy' => 'Alergi',
                'obat_id' => 'Obat',
                'hasil_pemeriksaan' => 'Hasil pemeriksaan'
            ];

            $validated = $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'nik' => 'required|string|max:16|unique:patients,nik',
                'address' => 'required|string',
                'allergy' => 'nullable|string',
                'obat_id' => 'required|exists:obats,id',
                'hasil_pemeriksaan' => 'required|string',
                'appointment_id' => 'required|exists:appointments,id',
                'penyakit' => 'required|string|max:255',
            ], $messages, $attributes);

            $appointment = Appointment::with('pengguna')->findOrFail($request->appointment_id);
            $validated['pengguna_id'] = $appointment->pengguna_id;
            $validated['tanggal_lahir'] = $appointment->pengguna->birth_date;
            $validated['gender'] = $appointment->pengguna->gender;
            $validated['keluhan'] = $appointment->keluhan_utama;
            $validated['tanggal_reservasi'] = $appointment->tanggal_reservasi;
            $validated['tanggal_pelaksanaan'] = $appointment->tanggal_pelaksanaan;
            $validated['jenis_perawatan'] = $appointment->jenis_perawatan ?? 'Rawat Jalan';
            $validated['penyakit'] = $request->penyakit;

            // Tambahkan default value untuk field yang tidak ada di form
            $validated['waktu_periksa'] = now(); // atau null jika nullable

            Patient::create($validated);

            return redirect()->route('patients.index')
                ->with('success', 'Data medical record berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['pengguna', 'appointment', 'obat']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $appointments = Appointment::with('pengguna')->get();
        $obats = Obat::all();
        return view('patients.edit', compact('patient', 'appointments', 'obats'));
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
                'nik.unique' => 'NIK sudah terdaftar dalam sistem. Mohon periksa kembali NIK yang dimasukkan.'
            ];

            $attributes = [
                'nama_pasien' => 'Nama pasien',
                'nik' => 'NIK',
                'address' => 'Alamat',
                'allergy' => 'Alergi',
                'obat_id' => 'Obat',
                'hasil_pemeriksaan' => 'Hasil pemeriksaan'
            ];

            $validated = $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'nik' => 'required|string|max:16|unique:patients,nik,' . $patient->id,
                'address' => 'required|string',
                'allergy' => 'nullable|string',
                'obat_id' => 'required|exists:obats,id',
                'hasil_pemeriksaan' => 'required|string',
                'appointment_id' => 'required|exists:appointments,id',
                'penyakit' => 'required|string|max:255',
            ], $messages, $attributes);

            $appointment = Appointment::with('pengguna')->findOrFail($request->appointment_id);
            $validated['pengguna_id'] = $appointment->pengguna_id;
            $validated['tanggal_lahir'] = $appointment->pengguna->birth_date;
            $validated['gender'] = $appointment->pengguna->gender;
            $validated['keluhan'] = $appointment->keluhan_utama;
            $validated['tanggal_reservasi'] = $appointment->tanggal_reservasi;
            $validated['tanggal_pelaksanaan'] = $appointment->tanggal_pelaksanaan;
            $validated['jenis_perawatan'] = $appointment->jenis_perawatan ?? 'Rawat Jalan';
            $validated['penyakit'] = $request->penyakit;

            $patient->update($validated);

            return redirect()->route('patients.index')
                ->with('success', 'Data medical record berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
            ->with('success', 'Data medical record berhasil dihapus.');
    }
}
