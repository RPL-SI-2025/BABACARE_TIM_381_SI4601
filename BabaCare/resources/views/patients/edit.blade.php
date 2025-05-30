@extends('layouts.app')

@section('title', 'Edit Medical Record')
@section('header', 'Edit Medical Record')

@section('content')
<div class="space-y-6">
    <div class="flex items-center">
        <a href="{{ route('patients.index') }}" class="flex items-center text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Medical Record
        </a>
    </div>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form id="editPatientForm" action="{{ route('patients.update', $patient) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nama Pasien -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                    <input type="text" name="nama_pasien" value="{{ old('nama_pasien', $patient->nama_pasien) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $patient->nik) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Gender</option>
                        <option value="Laki-laki" {{ old('gender', $patient->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $patient->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $patient->tanggal_lahir ? $patient->tanggal_lahir->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('address', $patient->address) }}</textarea>
                </div>

                <!-- Allergy -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alergi</label>
                    <textarea name="allergy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('allergy', $patient->allergy) }}</textarea>
                </div>

                <!-- Tanggal Reservasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Reservasi</label>
                    <input type="date" name="tanggal_reservasi" value="{{ old('tanggal_reservasi', $patient->tanggal_reservasi ? $patient->tanggal_reservasi->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Tanggal Pelaksanaan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $patient->tanggal_pelaksanaan ? $patient->tanggal_pelaksanaan->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Keluhan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Keluhan</label>
                    <textarea name="keluhan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('keluhan', $patient->keluhan) }}</textarea>
                </div>

                <!-- Jenis Perawatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Perawatan</label>
                    <select name="jenis_perawatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Jenis Perawatan</option>
                        <option value="Rawat Inap" {{ old('jenis_perawatan', $patient->jenis_perawatan) == 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                        <option value="Rawat Jalan" {{ old('jenis_perawatan', $patient->jenis_perawatan) == 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                        <option value="UGD" {{ old('jenis_perawatan', $patient->jenis_perawatan) == 'UGD' ? 'selected' : '' }}>UGD</option>
                    </select>
                </div>

                <!-- Waktu Periksa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Waktu Periksa</label>
                    <input type="datetime-local" name="waktu_periksa" value="{{ old('waktu_periksa', $patient->waktu_periksa ? $patient->waktu_periksa->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Penyakit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Penyakit</label>
                    <input dusk="penyakit" type="text" name="penyakit" value="{{ old('penyakit', $patient->penyakit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Obat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Obat</label>
                    <select dusk="obat_id" name="obat_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Obat</option>
                        @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" {{ old('obat_id', $patient->obat_id) == $obat->id ? 'selected' : '' }}>{{ $obat->nama_obat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hasil Pemeriksaan -->
                <div class="col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Hasil Pemeriksaan</label>
                    <textarea name="hasil_pemeriksaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="4" required>{{ old('hasil_pemeriksaan', $patient->hasil_pemeriksaan) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button dusk="submit-patient" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection