@extends('layouts.Admin')

@section('title', 'Edit Obat')
@section('header', 'Edit Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Obat</h2>

    <form action="{{ route('obats.update', $obat->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_obat" class="block mb-2 text-sm font-semibold text-gray-700">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" value="{{ $obat->nama_obat }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div>
            <label for="kategori" class="block mb-2 text-sm font-semibold text-gray-700">Kategori</label>
            <input type="text" name="kategori" id="kategori" value="{{ $obat->kategori }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div>
            <label for="golongan" class="block mb-2 text-sm font-semibold text-gray-700">Golongan</label>
            <input type="text" name="golongan" id="golongan" value="{{ $obat->golongan }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('obats.index') }}" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
