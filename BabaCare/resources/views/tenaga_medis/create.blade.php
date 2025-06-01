
@extends('layouts.Admin')

@section('title', 'Tambah Tenaga Medis')
@section('header', 'Tambah Tenaga Medis')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Tenaga Medis</h2>

    <form action="{{ route('tenaga_medis.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nama" class="block mb-2 text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none 
                @error('nama') border-red-500 @enderror">
            @error('nama')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none
                @error('email') border-red-500 @enderror">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none
                @error('password') border-red-500 @enderror">
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('tenaga_medis.index') }}" 
                class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
                Batal
            </a>
            <button type="submit" 
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection