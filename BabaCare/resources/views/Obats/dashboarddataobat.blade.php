@extends('layouts.Admin')

@section('title', 'Dashboard Data Obat')
@section('header', 'Dashboard Data Obat')

@section('content')
<div class="p-8 max-w-6xl mx-auto bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Data Obat</h2>

    <div class="grid grid-cols-3 gap-4">
        <!-- Total Obat -->
        <div class="p-4 border rounded-lg bg-gray-100 text-center">
            <h3 class="text-lg font-semibold">Total Obat</h3>
            <p class="text-2xl">{{ $totalObat }}</p>
        </div>

        <!-- Obat Per Kategori -->
        <div class="p-4 border rounded-lg bg-gray-100 text-center">
            <h3 class="text-lg font-semibold">Obat per Kategori</h3>
            <ul class="text-sm mt-2">
                <!-- Obat Per Kategori -->
                @foreach ($jumlahPerKategori as $kategori)
                    <li>{{ $kategori->nama_kategori }}: {{ $kategori->obats_count }} obat</li>
                @endforeach
            </ul>
        </div>

        <!-- Obat Per Golongan -->
        <div class="p-4 border rounded-lg bg-gray-100 text-center">
            <h3 class="text-lg font-semibold">Obat per Golongan</h3>
            <ul class="text-sm mt-2">
                <!-- Obat Per Golongan -->
                @foreach ($jumlahPerGolongan as $golongan)
                    <li>{{ $golongan->nama_golongan }}: {{ $golongan->obats_count }} obat</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-semibold">Daftar Obat</h3>
        <table class="min-w-full mt-4 table-auto border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nama Obat</th>
                    <th class="px-4 py-2 border-b">Kategori</th>
                    <th class="px-4 py-2 border-b">Golongan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($obats as $obat)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $obat->nama_obat }}</td>
                        <td class="px-4 py-2 border-b">{{ $obat->kategori->nama_kategori }}</td>
                        <td class="px-4 py-2 border-b">{{ $obat->golongan->nama_golongan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
