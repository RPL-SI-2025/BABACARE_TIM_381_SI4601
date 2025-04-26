@extends('layouts.app')

@section('title', 'Detail Obat')

@section('header', 'Detail Obat')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Detail Obat: {{ $obat->nama_obat }}</h2>

        <div class="mt-4">
            <div class="mb-4">
                <strong class="text-gray-600">Nama Obat:</strong>
                <p class="text-gray-800">{{ $obat->nama_obat }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-600">Kategori:</strong>
                <p class="text-gray-800">{{ $obat->kategori }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-600">Golongan:</strong>
                <p class="text-gray-800">{{ $obat->golongan }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-600">Tanggal Dibuat:</strong>
                <p class="text-gray-800">{{ $obat->created_at->format('d-m-Y H:i') }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-600">Tanggal Diperbarui:</strong>
                <p class="text-gray-800">{{ $obat->updated_at->format('d-m-Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('obats.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kembali ke Daftar Obat</a>
            <a href="{{ route('obats.edit', $obat->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit Obat</a>
        </div>
    </div>
@endsection
