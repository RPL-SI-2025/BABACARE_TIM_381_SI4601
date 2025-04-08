<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function create()
    {
        $specialists = [
            'Umum' => 'Dokter Umum',
            'Bidan' => 'Dokter Bidan',
        ];
        
        return view('appointments.create', compact('specialists'));
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'tanggal_reservasi' => 'required|date|after_or_equal:today',
                'tanggal_pelaksanaan' => 'required|date|after_or_equal:tanggal_reservasi',
                'waktu_pelaksanaan' => 'required',
                'specialist' => 'required|string',
                'keluhan_utama' => 'required|string'
            ]);
            
            $appointment = new Appointment();
            $appointment->user_id = $user->id;
            $appointment->tanggal_reservasi = $validated['tanggal_reservasi'];
            $appointment->tanggal_pelaksanaan = $validated['tanggal_pelaksanaan'];
            $appointment->waktu_pelaksanaan = $validated['waktu_pelaksanaan'];
            $appointment->specialist = $validated['specialist'];
            $appointment->keluhan_utama = $validated['keluhan_utama'];
            $appointment->status = 'pending';
            $appointment->save();
            
            return redirect()->route('appointments.my')
                ->with('success', 'Janji temu berhasil dibuat.');
                
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi data.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat janji temu.');
        }
    }
}