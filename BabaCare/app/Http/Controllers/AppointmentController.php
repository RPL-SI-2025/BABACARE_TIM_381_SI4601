<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
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
        return view('appointments.create');
    }

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
                'tanggal_reservasi' => 'required|date|after_or_equal:today',
                'tanggal_pelaksanaan' => 'required|date|after_or_equal:tanggal_reservasi',
                'waktu_pelaksanaan' => 'required|string',
                'keluhan_utama' => 'required|string',
            ], $messages, [
                'tanggal_reservasi' => 'Tanggal Reservasi',
                'tanggal_pelaksanaan' => 'Tanggal Pelaksanaan',
                'waktu_pelaksanaan' => 'Waktu Pelaksanaan',
                'keluhan_utama' => 'Keluhan Utama',
            ]);
            
            $appointment = Appointment::create([
                'pengguna_id' => Auth::id(),
                'tanggal_reservasi' => $validated['tanggal_reservasi'],
                'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],
                'waktu_pelaksanaan' => $validated['waktu_pelaksanaan'],
                'keluhan_utama' => $validated['keluhan_utama']
            ]);

            return redirect()->route('appointments.create')
                ->with('success', 'Janji temu berhasil dibuat.');
                    
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
}