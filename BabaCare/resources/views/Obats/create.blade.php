@extends('layouts.Admin')

@section('title', 'Tambah Obat')
@section('header', 'Tambah Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Obat</h2>

    <form action="{{ route('obats.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nama_obat" class="block mb-2 text-sm font-semibold text-gray-700">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div>
            <label for="kategori_id" class="block mb-2 text-sm font-semibold text-gray-700">Kategori</label>
            <select name="kategori_id" id="kategori_id" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="golongan_id" class="block mb-2 text-sm font-semibold text-gray-700">Golongan</label>
            <select name="golongan_id" id="golongan_id" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Pilih Golongan --</option>
                @foreach ($golongans as $golongan)
                    <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('obats.index') }}" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
