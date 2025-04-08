@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Management Pasien Card -->
    <a href="{{ route('patients.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i class="fas fa-user text-3xl text-blue-500 mr-3"></i>
                <h3 class="text-xl font-semibold text-gray-800">Management Pasien</h3>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
        <p class="text-gray-600">Kelola data pasien, tambah pasien baru, dan lihat riwayat perawatan.</p>
    </a>

    <!-- Laporan Data Pasien Card -->
    <a href="{{ route('reports.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-3xl text-green-500 mr-3"></i>
                <h3 class="text-xl font-semibold text-gray-800">Laporan Data Pasien</h3>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
        <p class="text-gray-600">Lihat laporan dan statistik data pasien.</p>
    </a>
</div>

<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-users text-3xl text-blue-500 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Total Pasien</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $totalPatients ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-calendar-day text-3xl text-green-500 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Pasien Hari Ini</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $todayPatients ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <i class="fas fa-procedures text-3xl text-red-500 mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Dalam Perawatan</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $inCarePatients ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di BabaCare</h2>
    <p class="text-gray-600 mb-4">Sistem manajemen pasien yang membantu Anda dalam mengelola data pasien dengan lebih efisien.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Manajemen data pasien yang terintegrasi</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Pencatatan riwayat perawatan yang lengkap</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Laporan dan statistik yang informatif</p>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
            <p class="text-gray-600">Antarmuka yang mudah digunakan</p>
        </div>
    </div>
</div>
@endsection