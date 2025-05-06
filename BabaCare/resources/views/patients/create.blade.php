@extends('layouts.app')

@section('title', 'Management Pasien')
@section('header', 'Management Pasien')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="createPatientForm" action="{{ route('patients.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Nama Pasien -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <input dusk="nama_pasien" type="text" name="nama_pasien" value="{{ old('nama_pasien') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_pasien') border-red-300 @enderror" required>
                @error('nama_pasien')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select dusk="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-300 @enderror" required>
                    <option value="">Pilih Gender</option>
                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input dusk="nik" type="text" name="nik" value="{{ old('nik') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-300 @enderror" required>
                @error('nik')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input dusk="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_lahir') border-red-300 @enderror" required>
                @error('tanggal_lahir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Perawatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Perawatan</label>
                <select dusk="jenis_perawatan" name="jenis_perawatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_perawatan') border-red-300 @enderror" required>
                    <option value="">Pilih Jenis Perawatan</option>
                    <option value="Rawat Inap" {{ old('jenis_perawatan') == 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                    <option value="Rawat Jalan" {{ old('jenis_perawatan') == 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                    <option value="UGD" {{ old('jenis_perawatan') == 'UGD' ? 'selected' : '' }}>UGD</option>
                </select>
                @error('jenis_perawatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu Periksa -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu Periksa</label>
                <input dusk="waktu_periksa" type="datetime-local" name="waktu_periksa" value="{{ old('waktu_periksa') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('waktu_periksa') border-red-300 @enderror" required>
                @error('waktu_periksa')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Penyakit -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Penyakit</label>
                <select dusk="penyakit" name="penyakit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('penyakit') border-red-300 @enderror" required>
                    <option value="">Pilih Penyakit</option>
                    <option value="Demam" {{ old('penyakit') == 'Demam' ? 'selected' : '' }}>Demam</option>
                    <option value="Flu" {{ old('penyakit') == 'Flu' ? 'selected' : '' }}>Flu</option>
                    <option value="Batuk" {{ old('penyakit') == 'Batuk' ? 'selected' : '' }}>Batuk</option>
                    <option value="Diare" {{ old('penyakit') == 'Diare' ? 'selected' : '' }}>Diare</option>
                    <option value="Lainnya" {{ old('penyakit') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('penyakit')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Obat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Obat</label>
                <select dusk="obat" name="obat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('obat') border-red-300 @enderror" required>
                    <option value="">Pilih Obat</option>
                    <option value="Paracetamol" {{ old('obat') == 'Paracetamol' ? 'selected' : '' }}>Paracetamol</option>
                    <option value="Amoxicillin" {{ old('obat') == 'Amoxicillin' ? 'selected' : '' }}>Amoxicillin</option>
                    <option value="Ibuprofen" {{ old('obat') == 'Ibuprofen' ? 'selected' : '' }}>Ibuprofen</option>
                    <option value="Lainnya" {{ old('obat') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('obat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Hasil Pemeriksaan -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Hasil Pemeriksaan</label>
            <textarea dusk="hasil_pemeriksaan" name="hasil_pemeriksaan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('hasil_pemeriksaan') border-red-300 @enderror" required>{{ old('hasil_pemeriksaan') }}</textarea>
            @error('hasil_pemeriksaan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-start space-x-4">
            <button dusk="submit-button" type="button" onclick="confirmSubmit()" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Save
            </button>
            <a href="{{ route('patients.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function confirmSubmit() {
    Swal.fire({
        title: 'Konfirmasi Penambahan Data',
        text: "Apakah Anda yakin ingin menambahkan data pasien ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tambahkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('createPatientForm').submit();
        }
    });
}

// Show error message if exists using SweetAlert2
@if(session('error') || $errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        @if(session('error'))
            text: "{{ session('error') }}",
        @else
            text: "Mohon periksa kembali data yang dimasukkan.",
        @endif
        confirmButtonText: 'Ok'
    });
@endif
</script>
@endpush 