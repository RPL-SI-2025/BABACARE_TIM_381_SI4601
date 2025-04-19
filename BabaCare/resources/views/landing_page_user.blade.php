@extends('layouts.app')

@section('title', 'Dashboard Pasien')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Pendaftaran Janji Temu -->
    <a href="{{ route('appointments.create') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i class="fas fa-calendar-plus text-3xl text-blue-500 mr-3"></i>
                <h3 class="text-xl font-semibold text-gray-800">Pendaftaran Janji Temu</h3>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
        <p class="text-gray-600">Ajukan janji temu baru dengan dokter spesialis pilihan Anda.</p>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-notes-medical text-3xl text-green-500 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Janji Temu</h3>
                <p class="text-sm text-gray-600">Lihat status dan jadwal janji temu Anda</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-user text-3xl text-blue-400 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Profil Pasien</h3>
                <p class="text-sm text-gray-600">Informasi pribadi dan kontak Anda</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-shield-alt text-3xl text-yellow-500 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Status Pendaftaran</h3>
                <p class="text-sm text-gray-600">Cek status pendaftaran janji temu Anda</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di BabaCare</h2>
    <p class="text-gray-600 mb-4">Platform pendaftaran dan manajemen janji temu kesehatan Anda.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Pendaftaran janji temu cepat dan mudah</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Notifikasi jadwal dan status janji temu</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Riwayat konsultasi dapat dilihat kapan saja</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Privasi dan keamanan data Anda terjamin</p>
        </div>
    </div>
</div>
@endsection
