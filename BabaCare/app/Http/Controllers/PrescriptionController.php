<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'staff', 'patient.obat']);
        
        // Simple ordering
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $prescriptions = $query->paginate(10);
        
        return view('prescriptions.index', compact('prescriptions'));
    }
    
    public function create()
    {
        $patients = Patient::with('obat')->get();
        $obats = Obat::all(); // Add this line
        
        return view('prescriptions.create', compact('patients', 'obats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'drugs_allergies' => 'nullable|string|max:1000',
        ]);
        
        // Get the patient to access their obat_id
        $patient = Patient::find($validatedData['patient_id']);
        
        $prescriptionData = array_merge($validatedData, [
            'prescription_code' => Prescription::generatePrescriptionCode(),
            'obat_id' => $patient->obat_id, // Use patient's obat_id
            'staff_id' => Auth::id(),
        ]);
        
        $prescription = Prescription::create($prescriptionData);
        
        return redirect()->route('referrals.index', ['category' => 'resep'])
            ->with('success', 'Resep obat berhasil dibuat');
    }
    // public function create()
    // {
    //     $patients = Patient::with('obat')->get();
        
    //     return view('prescriptions.create', compact('patients'));
    // }
    
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'patient_id' => 'required|exists:patients,id',
    //         'drugs_allergies' => 'nullable|string|max:1000',
    //     ]);
        
    //     $prescriptionData = array_merge($validatedData, [
    //         'prescription_code' => Prescription::generatePrescriptionCode(),
    //         'staff_id' => Auth::id(),
    //     ]);
        
    //     $prescription = Prescription::create($prescriptionData);
        
    //     return redirect()->route('referrals.index', ['category' => 'resep'])
    //         ->with('success', 'Resep obat berhasil dibuat');
    // }
    
    public function edit(Prescription $prescription)
    {
        $patients = Patient::with('obat')->get();
        
        return view('prescriptions.edit', compact('prescription', 'patients'));
    }
    
    public function update(Request $request, Prescription $prescription)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'drugs_allergies' => 'nullable|string|max:1000',
        ]);
        
        $prescription->update($validatedData);
        
        return redirect()->route('referrals.index', ['category' => 'resep'])
            ->with('success', 'Resep obat berhasil diperbarui');
    }
    
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        
        return redirect()->route('referrals.index', ['category' => 'resep'])
            ->with('success', 'Resep obat berhasil dihapus');
    }
    
    public function downloadPDF(Prescription $prescription)
    {
        $prescription->load(['patient', 'staff', 'patient.obat']);
        $pdf = PDF::loadView('pdfs.prescription', compact('prescription'));
        return $pdf->download('prescription_' . $prescription->prescription_code . '.pdf');
    }
}