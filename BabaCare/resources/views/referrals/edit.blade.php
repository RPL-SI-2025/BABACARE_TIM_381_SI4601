@extends('layouts.app')

@section('title', isset($referral) ? 'Edit Surat Dokter' : 'Tambah Surat Dokter')
@section('header', isset($referral) ? 'Edit Surat Dokter' : 'Tambah Surat Dokter')

@section('content')
<div class="container mx-auto px-4 py-8">
    <form action="{{ isset($referral) ? route('referrals.update', $referral) : route('referrals.store') }}" 
          method="POST" 
          class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @if(isset($referral))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pasien -->
            <div class="mb-4">
                <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">
                    Nama Pasien <span class="text-red-500">*</span>
                </label>
                <select dusk="patient_id" name="patient_id" id="patient_id" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        >
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" 
                                {{ (isset($referral) && $referral->patient_id == $patient->id) || old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->nama_pasien }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rumah Sakit Tujuan -->
            <div class="mb-4">
                <label for="destination_hospital_id" class="block text-gray-700 text-sm font-bold mb-2">
                    Nama Rumah Sakit Tujuan <span class="text-red-500">*</span>
                </label>
                <select dusk="destination_hospital_id" name="destination_hospital_id" id="destination_hospital_id" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        >
                    <option value="">Pilih Rumah Sakit</option>
                    @foreach($hospitals as $hospital)
                        <option value="{{ $hospital->id }}" 
                                {{ (isset($referral) && $referral->destination_hospital_id == $hospital->id) || old('destination_hospital_id') == $hospital->id ? 'selected' : '' }}>
                            {{ $hospital->nama_rumah_sakit }}
                        </option>
                    @endforeach
                </select>
                @error('destination_hospital_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-4">
                <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">
                    Jenis Kelamin
                </label>
                <textarea name="gender" id="gender" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          readonly rows="3">{{ old('gender', $referral->gender ?? '') }}</textarea>
                <!-- <input type="text" name="gender" id="gender" 
                       value="{{ old('gender', isset($referral) ? ($referral->gender === 'Laki-laki' ? 'Laki-laki' : ($referral->gender === 'female' ? 'Perempuan' : '')) : '') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       readonly> -->
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">
                    Alamat
                </label>
                <textarea name="address" id="address" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          readonly rows="3">{{ old('address', $referral->address ?? '') }}</textarea>
            </div>

            <!-- Hasil Pemeriksaan -->
            <div class="mb-4">
                <label for="hasil_pemeriksaan" class="block text-gray-700 text-sm font-bold mb-2">
                    Hasil Pemeriksaan
                </label>
                <textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          readonly rows="3">{{ old('hasil_pemeriksaan', $referral->hasil_pemeriksaan ?? '') }}</textarea>
            </div>

            <!-- Keadaan Saat Rujuk -->
            <div class="mb-4">
                <label for="keadaan_saat_rujuk" class="block text-gray-700 text-sm font-bold mb-2">
                    Keadaan Saat Rujuk
                </label>
                <textarea dusk="keadaan_saat_rujuk" name="keadaan_saat_rujuk" id="keadaan_saat_rujuk" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          rows="3">{{ old('keadaan_saat_rujuk', $referral->keadaan_saat_rujuk ?? '') }}</textarea>
                @error('keadaan_saat_rujuk')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex items-center justify-between mt-6">
            <button type="submit" 
                    dusk="submit-referral"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ isset($referral) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('referrals.index') }}" 
               class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const patientSelect = document.getElementById('patient_id');
        const genderInput = document.getElementById('gender');
        const addressInput = document.getElementById('address');
        const hasilPemeriksaanInput = document.getElementById('hasil_pemeriksaan');

        patientSelect.addEventListener('change', function() {
            if (this.value) {
                fetch(`/referrals/patient-details?patient_id=${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        genderInput.value = data.gender === 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
                        addressInput.value = data.address;
                        hasilPemeriksaanInput.value = data.hasil_pemeriksaan;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengambil detail pasien');
                    });
            } else {
                genderInput.value = '';
                addressInput.value = '';
                hasilPemeriksaanInput.value = '';
            }
        });
    });
</script>
@endpush
