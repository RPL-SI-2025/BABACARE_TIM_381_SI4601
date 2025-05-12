<?php

namespace App\Http\Controllers;

use App\Models\Referral;
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
        
        $query = Referral::query();
        
        // Search functionality
        if ($request->has('search')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('nama_pasien', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $referrals = $query->paginate(10);
        
        return view('referrals.index', compact('referrals', 'category'));
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
            'kode_rujukan' => Referral::generateReferralCode(),
            'staff_id' => Auth::id(),
            'gender' => $patient->gender,
            'address' => $patient->address,
            'hasil_pemeriksaan' => $patient->hasil_pemeriksaan,
            'pengobatan_sementara' => $patient->keluhan, // Using complaint as temporary treatment
            'origin_hospital_id' => config('hospital.origin_hospital_id') // From config
        ]);
        
        $referral = Referral::create($referralData);
        
        return redirect()->route('referrals.index')
            ->with('success', 'Referral created successfully');
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
            ->with('success', 'Referral updated successfully');
    }
    
    public function destroy(Referral $referral)
    {
        $referral->delete();
        
        return redirect()->route('referrals.index')
            ->with('success', 'Referral deleted successfully');
    }
    
    public function downloadPDF(Referral $referral)
    {
        $pdf = PDF::loadView('pdfs.referral', compact('referral'));
        return $pdf->download('referral_' . $referral->kode_rujukan . '.pdf');
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