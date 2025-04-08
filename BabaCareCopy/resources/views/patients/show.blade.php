@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('header', 'Detail Pasien')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('patients.index') }}" class="flex items-center text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pasien
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('patients.edit', $patient) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pasien</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Pasien</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->nama_pasien }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIK</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->gender }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->tanggal_lahir->format('d/m/Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pemeriksaan</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jenis Perawatan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->jenis_perawatan }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Waktu Periksa</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->waktu_periksa->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Penyakit</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->penyakit }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Obat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $patient->obat }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Hasil Pemeriksaan</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $patient->hasil_pemeriksaan }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 