@extends('layouts.app')

@section('title', 'Surat Dokter')
@section('header', 'Surat Dokter')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-4 items-center">
            <select id="category" class="form-select rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="rujukan" {{ request('category', 'rujukan') == 'rujukan' ? 'selected' : '' }}>Rujukan</option>
                <option value="resep" {{ request('category') == 'resep' ? 'selected' : '' }}>Resep Obat</option>
            </select>

            <a href="{{ route('referrals.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i> Tambah
            </a>
        </div>
        
        <div class="flex items-center space-x-4">
            <form action="{{ route('referrals.index') }}" method="GET" class="flex items-center">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}" 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="ml-2 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('referrals.index', array_merge(request()->query(), ['sort' => 'patient_id', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            ID Pasien
                            @if(request('sort') == 'patient_id')
                                <i class="fas fa-sort-{{ request('direction', 'asc') == 'asc' ? 'down' : 'up' }} ml-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('referrals.index', array_merge(request()->query(), ['sort' => 'kode_rujukan', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Kode Rujukan
                            @if(request('sort') == 'kode_rujukan')
                                <i class="fas fa-sort-{{ request('direction', 'asc') == 'asc' ? 'down' : 'up' }} ml-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('referrals.index', array_merge(request()->query(), ['sort' => 'patient.nama_pasien', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Nama Pasien
                            @if(request('sort') == 'patient.nama_pasien')
                                <i class="fas fa-sort-{{ request('direction', 'asc') == 'asc' ? 'down' : 'up' }} ml-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('referrals.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                            Tanggal Surat
                            @if(request('sort') == 'created_at')
                                <i class="fas fa-sort-{{ request('direction', 'asc') == 'asc' ? 'down' : 'up' }} ml-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($referrals as $referral)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $referral->patient_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $referral->kode_rujukan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $referral->patient->nama_pasien }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $referral->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('referrals.download', $referral) }}" class="text-blue-600 hover:text-blue-900" title="Download PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('referrals.edit', $referral) }}" class="text-green-600 hover:text-green-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('referrals.destroy', $referral) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $referral->id }}, '{{ $referral->kode_rujukan }}')" 
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data surat dokter
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $referrals->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Category dropdown change handler
    document.getElementById('category').addEventListener('change', function() {
        window.location.href = "{{ route('referrals.index') }}?category=" + this.value;
    });

    function confirmDelete(referralId, referralCode) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: `Apakah Anda yakin ingin menghapus surat dokter dengan kode ${referralCode}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                const form = event.target.closest('form');
                form.submit();
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