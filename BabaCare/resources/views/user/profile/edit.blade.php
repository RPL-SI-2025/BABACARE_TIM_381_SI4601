@extends('layouts.app')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Personal Information Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
        <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="space-y-2">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Nama Depan</label>
                    <input id="first_name" type="text" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" 
                           name="first_name" 
                           value="{{ old('first_name', $user->first_name ?? '') }}" 
                           required>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="space-y-2">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                    <input id="last_name" type="text" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" 
                           name="last_name" 
                           value="{{ old('last_name', $user->last_name ?? '') }}" 
                           required>
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                           name="email" 
                           value="{{ old('email', $user->email ?? '') }}" 
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp Number -->
                <div class="space-y-2">
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input id="whatsapp_number" type="text" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('whatsapp_number') border-red-500 @enderror" 
                           name="whatsapp_number" 
                           value="{{ old('whatsapp_number', $user->whatsapp_number ?? '') }}" 
                           required>
                    @error('whatsapp_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age -->
                <div class="space-y-2">
                    <label for="age" class="block text-sm font-medium text-gray-700">Usia</label>
                    <input id="age" type="number" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('age') border-red-500 @enderror" 
                           name="age" 
                           value="{{ old('age', $user->age ?? '') }}" 
                           required>
                    @error('age')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div class="space-y-2">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input id="date_of_birth" type="date" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror" 
                           name="date_of_birth" 
                           value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" 
                           required>
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="address" 
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror" 
                          name="address" 
                          rows="3" 
                          required>{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Medical Information Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Medis</h3>
            
            <!-- Allergies -->
            <div class="space-y-2">
                <label for="allergies" class="block text-sm font-medium text-gray-700">Alergi</label>
                <textarea id="allergies" 
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('allergies') border-red-500 @enderror" 
                          name="allergies" 
                          rows="2">{{ old('allergies', $user->allergies ?? '') }}</textarea>
                @error('allergies')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Visit History -->
            <div class="mt-6 space-y-2">
                <label for="visit_history" class="block text-sm font-medium text-gray-700">Riwayat Kunjungan</label>
                <textarea id="visit_history" 
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('visit_history') border-red-500 @enderror" 
                          name="visit_history" 
                          rows="2">{{ old('visit_history', $user->visit_history ?? '') }}</textarea>
                @error('visit_history')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Medical History -->
            <div class="mt-6 space-y-2">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                <textarea id="medical_history" 
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('medical_history') border-red-500 @enderror" 
                          name="medical_history" 
                          rows="2">{{ old('medical_history', $user->medical_history ?? '') }}</textarea>
                @error('medical_history')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Password Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input id="current_password" type="password" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('current_password') border-red-500 @enderror" 
                           name="current_password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input id="new_password" type="password" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('new_password') border-red-500 @enderror" 
                           name="new_password">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="space-y-2">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input id="new_password_confirmation" type="password" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           name="new_password_confirmation">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection 