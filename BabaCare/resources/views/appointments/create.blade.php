@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')
@section('header', 'Pendaftaran Pasien')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 max-w-5xl mx-auto">
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

    <form id="createAppointmentForm" action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 gap-y-4">
            <!-- Tanggal Reservasi -->
            <div class="relative">
                <label for="tanggal_reservasi" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Reservasi</label>
                <input type="date" id="tanggal_reservasi" name="tanggal_reservasi" 
                       value="{{ old('tanggal_reservasi', date('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6">
                    <i class="fas fa-calendar text-gray-400"></i>
                </span>
            </div>
            
            <!-- Tanggal Pelaksanaan -->
            <div class="relative">
                <label for="tanggal_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan</label>
                <input type="date" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" 
                       value="{{ old('tanggal_pelaksanaan') }}" 
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6">
                    <i class="fas fa-calendar text-gray-400"></i>
                </span>
            </div>
            
            <!-- Waktu Pelaksanaan -->
            <div class="relative">
                <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Waktu Pelaksanaan</label>
                <input type="time" id="waktu_pelaksanaan" name="waktu_pelaksanaan" 
                       value="{{ old('waktu_pelaksanaan') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6">
                    <i class="fas fa-clock text-gray-400"></i>
                </span>
            </div>
            
            <!-- Specialist -->
            <div class="relative">
                <label for="specialist" class="block text-sm font-medium text-gray-700 mb-1">Specialist</label>
                <select id="specialist" name="specialist" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 appearance-none" required>
                    <option value="">Pilih Spesialis</option>
                    @foreach($specialists as $key => $value)
                        <option value="{{ $key }}" {{ old('specialist') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </span>
            </div>
            
            <!-- Keluhan Utama -->
            <div>
                <label for="keluhan_utama" class="block text-sm font-medium text-gray-700 mb-1">Keluhan Utama</label>
                <textarea id="keluhan_utama" name="keluhan_utama" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>{{ old('keluhan_utama') }}</textarea>
            </div>
        </div>

        <div class="flex space-x-4 mt-6">
            <button type="submit" 
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-md transition duration-200 ease-in-out text-center">
                Daftar
            </button>
            <a href="{{ route('landing') }}" 
               class="flex-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 py-3 px-4 rounded-md transition duration-200 ease-in-out text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Set min date for tanggal_pelaksanaan based on tanggal_reservasi
    document.getElementById('tanggal_reservasi').addEventListener('change', function() {
        document.getElementById('tanggal_pelaksanaan').min = this.value;
        
        // If current pelaksanaan date is before reservasi date, update it
        const pelaksanaanInput = document.getElementById('tanggal_pelaksanaan');
        if (pelaksanaanInput.value && pelaksanaanInput.value < this.value) {
            pelaksanaanInput.value = this.value;
        }
    });
    
    // Show confirmation before submitting
    document.getElementById('createAppointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            text: "Apakah data yang Anda masukkan sudah benar?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Daftar Sekarang',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endpush