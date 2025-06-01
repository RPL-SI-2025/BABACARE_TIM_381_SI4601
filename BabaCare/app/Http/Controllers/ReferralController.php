<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category', 'rujukan');
        
        if ($category === 'resep') {
            $query = Prescription::with(['patient', 'staff']);
            
            // Simple ordering
            $sortField = $request->input('sort', 'created_at');
            $sortDirection = $request->input('direction', 'desc');
            $query->orderBy($sortField, $sortDirection);
            
            $prescriptions = $query->paginate(10);
            
            return view('referrals.index', compact('prescriptions', 'category'));
        } else {
            $query = Referral::with(['patient', 'destinationHospital', 'originHospital', 'staff']);
            
            // Simple ordering
            $sortField = $request->input('sort', 'created_at');
            $sortDirection = $request->input('direction', 'desc');
            $query->orderBy($sortField, $sortDirection);
            
            $referrals = $query->paginate(10);
            
            return view('referrals.index', compact('referrals', 'category'));
        }
    }
    
    public function create()
    {
        $patients = Patient::all();
        $hospitals = Hospital::all();
        
        return view('referrals.create', compact('patients', 'hospitals'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'destination_hospital_id' => 'required|exists:hospitals,id',
            'keadaan_saat_rujuk' => 'nullable|string',
        ]);
        
        // Get patient details
        $patient = Patient::findOrFail($request->patient_id);
        
        $referralData = array_merge($validatedData, [
            'referral_code' => Referral::generateReferralCode(),
            'staff_id' => Auth::id(),
            'gender' => $patient->gender,
            'address' => $patient->address,
            'hasil_pemeriksaan' => $patient->hasil_pemeriksaan,
            'pengobatan_sementara' => $patient->keluhan,
            'origin_hospital_id' => config('hospital.origin_hospital_id')
        ]);
        
        $referral = Referral::create($referralData);
        
        return redirect()->route('referrals.index')
            ->with('success', 'Rujukan berhasil dibuat');
    }
    
    public function edit(Referral $referral)
    {
        $patients = Patient::all();
        $hospitals = Hospital::all();
        
        return view('referrals.edit', compact('referral', 'patients', 'hospitals'));
    }
    
    public function update(Request $request, Referral $referral)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'destination_hospital_id' => 'required|exists:hospitals,id',
            'keadaan_saat_rujuk' => 'nullable|string',
        ]);
        
        $referral->update($validatedData);
        
        return redirect()->route('referrals.index')
            ->with('success', 'Rujukan berhasil diperbarui');
    }
    
    public function destroy(Referral $referral)
    {
        $referral->delete();
        
        return redirect()->route('referrals.index')
            ->with('success', 'Rujukan berhasil dihapus');
    }
    
    public function downloadPDF(Referral $referral)
    {
        $pdf = PDF::loadView('pdfs.referral', compact('referral'));
        return $pdf->download('referral_' . $referral->referral_code . '.pdf');
    }
    
    // AJAX method to get patient details
    public function getPatientDetails(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        
        return response()->json([
            'gender' => $patient->gender,
            'address' => $patient->address,
            'hasil_pemeriksaan' => $patient->hasil_pemeriksaan,
            'pengobatan_sementara' => $patient->keluhan
        ]);
    }
}