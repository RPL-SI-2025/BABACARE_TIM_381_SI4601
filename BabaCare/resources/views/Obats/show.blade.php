@extends('layouts.Admin')

@section('title', 'Detail Obat')
@section('header', 'Detail Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Obat</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-gray-500 text-sm">Nama Obat</p>
            <p class="text-lg font-semibold text-gray-800">{{ $obat->nama_obat }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Kategori</p>
            <p class="text-lg font-semibold text-gray-800">{{ $obat->kategori }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Golongan</p>
            <p class="text-lg font-semibold text-gray-800">{{ $obat->golongan }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Tanggal Dibuat</p>
            <p class="text-lg font-semibold text-gray-800">{{ $obat->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Tanggal Diperbarui</p>
            <p class="text-lg font-semibold text-gray-800">{{ $obat->updated_at->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-4">
        <a href="{{ route('obats.index') }}" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
            Kembali
        </a>
        <a href="{{ route('obats.edit', $obat->id) }}" class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg">
            Edit
        </a>
    </div>
</div>
@endsection
