@extends('layouts.app')

@section('title', 'Edit Obat')
@section('header', 'Edit Obat')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow space-y-6">

    <form action="{{ route('obats.update', $obat->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" value="{{ $obat->nama_obat }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="kategori" id="kategori" value="{{ $obat->kategori }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="golongan" class="block text-sm font-medium text-gray-700">Golongan</label>
            <input type="text" name="golongan" id="golongan" value="{{ $obat->golongan }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('obats.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Batal
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
