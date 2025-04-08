@extends('layouts.app') 
@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Data Obat</h2>
            <div class="flex space-x-2">
                <form action="{{ route('obat.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari Obat..." class="border rounded-lg px-4 py-2 w-64" value="{{ request('search') }}">
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Cari</button>
                </form>
                <a href="{{ route('obat.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Tambah Data Obat</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm text-left">
                <thead class="bg-blue-100 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama Obat</th>
                        <th class="px-4 py-2">Golongan Obat</th>
                        <th class="px-4 py-2">Jenis Obat</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obats as $obat)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $obat->id }}</td>
                        <td class="px-4 py-2">{{ $obat->nama }}</td>
                        <td class="px-4 py-2">{{ $obat->jenis }}</td>
                        <td class="px-4 py-2">{{ $obat->bentuk ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $obat->harga ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $obat->stok ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('obat.edit', $obat->id) }}" class="text-green-500 hover:text-green-700 mx-1">
                                ✏️
                            </a>
                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:text-red-700 mx-1">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $obats->links() }}
        </div>
    </div>
</div>
@endsection
