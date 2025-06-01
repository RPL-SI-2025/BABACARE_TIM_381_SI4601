@extends('layouts.Admin')

@section('title', 'Dashboard Data Obat')
@section('header', 'Dashboard Data Obat')

@section('content')
<div class="p-6 max-w-7xl mx-auto bg-white rounded-xl shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">📊 Ringkasan Data Obat</h2>

    {{-- Ringkasan Kartu --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Obat -->
        <div class="bg-blue-100 p-6 rounded-2xl shadow text-center">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">Total Obat</h3>
            <p class="text-4xl font-bold text-blue-900">{{ $totalObat }}</p>
        </div>

        <!-- Obat per Kategori -->
        <div class="bg-green-100 p-6 rounded-2xl shadow">
            <h3 class="text-lg font-semibold text-green-800 mb-4 text-center">Obat per Kategori</h3>
            <ul class="text-sm space-y-1 text-gray-700">
                @foreach ($jumlahPerKategori as $kategori)
                    <li class="flex justify-between border-b pb-1">
                        <span>{{ $kategori->nama_kategori }}</span>
                        <span class="font-medium">{{ $kategori->obats_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Obat per Golongan -->
        <div class="bg-yellow-100 p-6 rounded-2xl shadow">
            <h3 class="text-lg font-semibold text-yellow-800 mb-4 text-center">Obat per Golongan</h3>
            <ul class="text-sm space-y-1 text-gray-700">
                @foreach ($jumlahPerGolongan as $golongan)
                    <li class="flex justify-between border-b pb-1">
                        <span>{{ $golongan->nama_golongan }}</span>
                        <span class="font-medium">{{ $golongan->obats_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Daftar Obat --}}
    <div class="mt-12">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-semibold text-gray-800">📋 Daftar Obat Tersedia</h3>
            <a href="{{ route('obats.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                + Tambah Data Obat
            </a>
        </div>

        {{-- Scrollable table --}}
        <div class="overflow-y-auto max-h-96 border border-gray-300 rounded-lg shadow-sm">
            <table class="w-full text-left">
                <thead class="sticky top-0 bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">Nama Obat</th>
                        <th class="px-4 py-2 border-b">Kategori</th>
                        <th class="px-4 py-2 border-b">Golongan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obats as $obat)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $obat->nama_obat }}</td>
                            <td class="px-4 py-2 border-b">{{ $obat->kategori->nama_kategori }}</td>
                            <td class="px-4 py-2 border-b">{{ $obat->golongan->nama_golongan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500 italic">Tidak ada data obat tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
