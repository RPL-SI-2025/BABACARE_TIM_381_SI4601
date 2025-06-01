@extends('layouts.Admin')

@section('title', 'Manajemen Obat')

@section('header', 'Manajemen Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Obat</h2>
            <p class="text-gray-500 text-sm">Kelola data obat di sistem BabaCare</p>
        </div>
        <div class="relative">
            <input 
                type="text" 
                id="search" 
                placeholder="Cari nama obat..." 
                class="w-72 px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-400 focus:outline-none"
            >
            <i class="fas fa-search absolute right-4 top-2.5 text-gray-400"></i>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nama Obat</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-left">Golongan</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($obats as $obat)
                    <tr class="border-b hover:bg-gray-50 transition duration-200">
                        <td class="py-4 px-6">{{ $obat->id }}</td>
                        <td class="py-4 px-6">{{ $obat->nama_obat }}</td>
                        <td class="py-4 px-6">{{ $obat->kategori->nama_kategori }}</td>  <!-- Ganti ini -->
                        <td class="py-4 px-6">{{ $obat->golongan->nama_golongan }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center items-center space-x-4">
                                <a href="{{ route('obats.show', $obat) }}" class="text-green-500 hover:text-green-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('obats.edit', $obat) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="deleteForm-{{ $obat->id }}" action="{{ route('obats.destroy', $obat) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $obat->id }}, '{{ $obat->nama_obat }}')" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Data Obat Kosong/Tidak Ada Data Obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Floating Button -->
    <a href="{{ route('obats.create') }}" 
       class="fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition duration-300">
        <i class="fas fa-plus text-xl"></i>
    </a>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Data obat "${nama}" akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${id}`).submit();
            }
        });
    }

    document.getElementById('search').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            window.location.href = '{{ route("obats.index") }}?search=' + this.value;
        }
    });
</script>
@endpush
