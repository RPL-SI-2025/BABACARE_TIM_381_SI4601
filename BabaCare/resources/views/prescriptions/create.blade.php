@extends('layouts.app')

@section('title', 'Tambah Resep Obat')
@section('header', 'Tambah Resep Obat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Form Resep Obat</h2>
            <a href="{{ route('referrals.index', ['category' => 'resep']) }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <form action="{{ route('prescriptions.store') }}" method="POST" id="prescriptionForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient Selection -->
                <div class="md:col-span-2">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Pasien <span class="text-red-500">*</span>
                    </label>
                    <select dusk="patient_id" name="patient_id" id="patient_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->nama_pasien }} (ID: {{ $patient->id }} - NIK: {{ $patient->nik }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Patient Information Display -->
                <div class="md:col-span-2">
                    <div id="patientInfo" class="hidden bg-gray-50 p-4 rounded-md">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Informasi Pasien</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                                <p id="displayNama" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p id="displayGender" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                <p id="displayNik" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <p id="displayAddress" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Keluhan</label>
                                <p id="displayKeluhan" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Diagnosis</label>
                                <p id="displayPenyakit" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hasil Pemeriksaan</label>
                                <p id="displayHasil" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Obat yang Diresepkan</label>
                                <p id="displayObat" class="mt-1 text-sm text-gray-900">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 text-red-600">Alergi Pasien</label>
                                <p id="displayAllergy" class="mt-1 text-sm text-red-600 font-semibold">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drugs Allergies -->
                <div class="md:col-span-2">
                    <label for="drugs_allergies" class="block text-sm font-medium text-gray-700 mb-2">
                        Alergi Obat / Catatan Khusus
                    </label>
                    <textarea dusk="drugs_allergies" name="drugs_allergies" id="drugs_allergies" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Masukkan informasi tentang alergi obat atau catatan khusus lainnya...">{{ old('drugs_allergies') }}</textarea>
                    @error('drugs_allergies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi ini akan ditampilkan pada resep dan sangat penting untuk keamanan pasien
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('referrals.index', ['category' => 'resep']) }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" 
                        dusk="submit-prescriptions"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Simpan Resep
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script id="patients-data" type="application/json">
    {!! json_encode($patients) !!}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const patientSelect = document.getElementById('patient_id');
        const patientInfo = document.getElementById('patientInfo');

        // Ambil data dari script tag JSON
        const patients = JSON.parse(document.getElementById('patients-data').textContent);

        patientSelect.addEventListener('change', function () {
            const patientId = this.value;

            if (patientId) {
                patientInfo.classList.remove('hidden');
                document.getElementById('displayNama').textContent = 'Memuat...';

                const selectedPatient = patients.find(p => p.id == patientId);

                if (selectedPatient) {
                    document.getElementById('displayNama').textContent = selectedPatient.nama_pasien || '-';
                    document.getElementById('displayGender').textContent = selectedPatient.gender || '-';
                    document.getElementById('displayNik').textContent = selectedPatient.nik || '-';
                    document.getElementById('displayAddress').textContent = selectedPatient.address || '-';
                    document.getElementById('displayKeluhan').textContent = selectedPatient.keluhan || '-';
                    document.getElementById('displayPenyakit').textContent = selectedPatient.penyakit || '-';
                    document.getElementById('displayHasil').textContent = selectedPatient.hasil_pemeriksaan || '-';
                    
                    // Display medicine information
                    if (selectedPatient.obat) {
                        const obatInfo = `${selectedPatient.obat.nama_obat || 'N/A'} - ${selectedPatient.obat.jenis_obat || 'N/A'}`;
                        document.getElementById('displayObat').textContent = obatInfo;
                    } else {
                        document.getElementById('displayObat').textContent = 'Tidak ada obat yang diresepkan';
                    }
                    
                    // Display allergy information
                    const allergyInfo = selectedPatient.allergy || 'Tidak ada alergi yang tercatat';
                    document.getElementById('displayAllergy').textContent = allergyInfo;
                    
                    // Auto-fill drugs allergies if patient has allergy
                    if (selectedPatient.allergy) {
                        document.getElementById('drugs_allergies').value = `PERHATIAN: Pasien memiliki alergi - ${selectedPatient.allergy}`;
                    }
                }
            } else {
                patientInfo.classList.add('hidden');
                document.getElementById('drugs_allergies').value = '';
            }
        });

        if (patientSelect.value) {
            patientSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

@endpush