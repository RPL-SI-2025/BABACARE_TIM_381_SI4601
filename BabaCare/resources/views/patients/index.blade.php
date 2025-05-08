@extends('layouts.app')

@section('title', 'Pengelolaan data medical record pasien')
@section('header', 'Pengelolaan data medical record pasien')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-4">
            <a href="{{ route('patients.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i> Tambah Data Medical Record
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="search" placeholder="Cari pasien..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alergi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Reservasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pelaksanaan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $patient->nama_pasien }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $patient->nik }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $patient->tanggal_lahir ? $patient->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4">{{ $patient->address }}</td>
                    <td class="px-6 py-4">{{ $patient->allergy ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $patient->tanggal_reservasi ? $patient->tanggal_reservasi->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $patient->tanggal_pelaksanaan ? $patient->tanggal_pelaksanaan->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4">{{ $patient->keluhan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('patients.edit', $patient) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="deleteForm-{{ $patient->id }}" action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" dusk="delete-button-{{ $patient->id }}" onclick="confirmDelete({{ $patient->id }}, '{{ $patient->nama_pasien }}')" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('patients.show', $patient) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data medical record
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('search').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            window.location.href = '{{ route("patients.index") }}?search=' + this.value;
        }
    });

    function confirmDelete(patientId, patientName) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan Data',
            text: `Apakah Anda yakin ingin menghapus data medical record "${patientName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${patientId}`).submit();
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