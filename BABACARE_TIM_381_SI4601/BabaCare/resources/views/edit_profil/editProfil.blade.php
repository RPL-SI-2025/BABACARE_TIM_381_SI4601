@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('header', 'Edit Profil Pasien')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Nama Pasien</label>
            <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-semibold">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-semibold">Alamat</label>
            <textarea name="address" id="address" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('address', $patient->address) }}</textarea>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('patients.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
