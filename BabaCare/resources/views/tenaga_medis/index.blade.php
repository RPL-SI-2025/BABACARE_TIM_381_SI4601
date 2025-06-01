@extends('layouts.Admin')

@section('title', 'Manajemen Tenaga Medis')

@section('header', 'Manajemen Tenaga Medis')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Tenaga Medis</h2>
            <p class="text-gray-500 text-sm">Kelola data tenaga medis di sistem BabaCare</p>
        </div>
        <div class="relative">
            <input 
                type="text" 
                id="search" 
                placeholder="Cari nama tenaga medis..." 
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
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($tenagaMedis as $medis)
                    <tr class="border-b hover:bg-gray-50 transition duration-200">
                        <td class="py-4 px-6">{{ $medis->id }}</td>
                        <td class="py-4 px-6">{{ $medis->nama }}</td>
                        <td class="py-4 px-6">{{ $medis->email }}</td>
                        <td class="py-4 px-6">{{ $medis->role }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center items-center space-x-4">
                                <!-- View Button -->
                                <a href="{{ route('tenaga_medis.show', $medis->id) }}" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Edit Button -->
                                <a href="{{ route('tenaga_medis.edit', $medis->id) }}" dusk="edit-tenaga-medis-{{ $medis->id }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Button -->
                                <form id="deleteForm-{{ $medis->id }}" action="{{ route('tenaga_medis.destroy', $medis->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" dusk="delete-tenaga-medis-{{ $medis->id }}" onclick="confirmDelete({{ $medis->id }}, '{{ $medis->nama }}')" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data tenaga medis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Floating Button -->
    <a href="{{ route('tenaga_medis.create') }}" 
       dusk="add-tenaga-medis"
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
            text: `Data tenaga medis "${nama}" akan dihapus permanen.`,
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
            window.location.href = '{{ route("tenaga_medis.index") }}?search=' + this.value;
        }
    });
</script>
@endpush