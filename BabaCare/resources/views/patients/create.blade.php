@extends('layouts.app')

@section('title', 'Pengelolaan data medical record pasien')
@section('header', 'Pengelolaan data medical record pasien')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="createPatientForm" action="{{ route('patients.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Appointment Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Appointment</label>
                <select name="appointment_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('appointment_id') border-red-300 @enderror" required>
                    <option value="">Pilih Appointment</option>
                    @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}" data-pengguna="{{ $appointment->pengguna }}" data-tanggal-reservasi="{{ $appointment->tanggal_reservasi }}" data-tanggal-pelaksanaan="{{ $appointment->tanggal_pelaksanaan }}" data-keluhan="{{ $appointment->keluhan }}">
                        {{ $appointment->pengguna->name }} - {{ $appointment->tanggal_pelaksanaan }}
                    </option>
                    @endforeach
                </select>
                @error('appointment_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pasien -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <input type="text" name="nama_pasien" id="nama_pasien" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_pasien') border-red-300 @enderror" required readonly>
                @error('nama_pasien')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-300 @enderror" required readonly>
                @error('nik')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <input type="text" name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-300 @enderror" required readonly>
                @error('gender')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Penyakit -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Penyakit</label>
                <input type="text" name="penyakit" id="penyakit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('penyakit') border-red-300 @enderror" required>
                @error('penyakit')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_lahir') border-red-300 @enderror" required readonly>
                @error('tanggal_lahir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-300 @enderror" required readonly></textarea>
                @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Allergy -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Alergi</label>
                <textarea name="allergy" id="allergy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('allergy') border-red-300 @enderror"></textarea>
                @error('allergy')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Obat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Obat</label>
                <select name="obat_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('obat_id') border-red-300 @enderror" required>
                    <option value="">Pilih Obat</option>
                    @foreach($obats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
                @error('obat_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hasil Pemeriksaan -->
            <div class="col-span-3">
                <label class="block text-sm font-medium text-gray-700">Hasil Pemeriksaan</label>
                <textarea name="hasil_pemeriksaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('hasil_pemeriksaan') border-red-300 @enderror" rows="4" required></textarea>
                @error('hasil_pemeriksaan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const appointmentSelect = document.querySelector('select[name="appointment_id"]');
    
    appointmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (!selectedOption.value) {
            return;
        }

        const pengguna = selectedOption.dataset.pengguna ? JSON.parse(selectedOption.dataset.pengguna) : null;
        if (!pengguna) {
            return;
        }

        // Fill in the form fields with pengguna data
        document.getElementById('nama_pasien').value = pengguna.name || '';
        document.getElementById('nik').value = pengguna.nik || '';
        document.getElementById('gender').value = pengguna.gender || '';
        document.getElementById('tanggal_lahir').value = pengguna.birth_date || '';
        document.getElementById('address').value = pengguna.address || '';
        document.getElementById('allergy').value = pengguna.allergy || '';
    });
});
</script>
@endpush
@endsection 