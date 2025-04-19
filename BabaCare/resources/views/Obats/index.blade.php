@extends('layouts.app')

@section('title', 'Daftar Obat')
@section('header', 'Data Obat')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-4">
            <a href="{{ route('obats.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i> Tambah Obat
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="search" placeholder="Cari obat..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Golongan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($obats as $obat)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->nama_obat }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->golongan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->kategori }}</td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('obats.edit', $obat) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="deleteForm-{{ $obat->id }}" action="{{ route('obats.destroy', $obat) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $obat->id }}, '{{ $obat->nama }}')" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('obats.show', $obat) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data obat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('search').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            window.location.href = '{{ route("obats.index") }}?search=' + this.value;
        }
    });

    function confirmDelete(obatId, obatName) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan Data',
            text: `Apakah Anda yakin ingin menghapus data obat "${obatName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${obatId}`).submit();
            }
        });
    }

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
