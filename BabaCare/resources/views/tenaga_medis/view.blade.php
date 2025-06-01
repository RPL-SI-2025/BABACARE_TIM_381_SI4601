
@extends('layouts.Admin')

@section('title', 'Detail Tenaga Medis')
@section('header', 'Detail Tenaga Medis')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Tenaga Medis</h2>
        <a href="{{ route('tenaga_medis.index') }}" 
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg">
            Kembali
        </a>
    </div>

    <div class="space-y-6">
        <div class="border-b pb-3">
            <p class="text-sm font-medium text-gray-500">Nama</p>
            <p class="mt-1 text-lg text-gray-800">{{ $tenagaMedis->nama }}</p>
        </div>

        <div class="border-b pb-3">
            <p class="text-sm font-medium text-gray-500">Email</p>
            <p class="mt-1 text-lg text-gray-800">{{ $tenagaMedis->email }}</p>
        </div>

        <div class="border-b pb-3">
            <p class="text-sm font-medium text-gray-500">Role</p>
            <p class="mt-1 text-lg text-gray-800">{{ $tenagaMedis->role }}</p>
        </div>

        <div class="border-b pb-3">
            <p class="text-sm font-medium text-gray-500">Tanggal Dibuat</p>
            <p class="mt-1 text-lg text-gray-800">
                {{ $tenagaMedis->created_at ? $tenagaMedis->created_at->format('d/m/Y H:i') : '-' }}
            </p>
        </div>

        <div class="border-b pb-3">
            <p class="text-sm font-medium text-gray-500">Terakhir Diperbarui</p>
            <p class="mt-1 text-lg text-gray-800">
                {{ $tenagaMedis->updated_at ? $tenagaMedis->updated_at->format('d/m/Y H:i') : '-' }}
            </p>
        </div>
    </div>

    <div class="flex justify-end space-x-4 mt-8">
        <a href="{{ route('tenaga_medis.edit', ['tenagaMedis' => $tenagaMedis]) }}" 
           class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
            Edit
        </a>
        <form action="{{ route('tenaga_medis.destroy', ['tenagaMedis' => $tenagaMedis]) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="button" 
                onclick="confirmDelete()" 
                class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg">
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data tenaga medis akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
}
</script>
@endpush