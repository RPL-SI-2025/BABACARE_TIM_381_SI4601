@extends('layouts.app')

@section('title', 'Edit Pasien')
@section('header', 'Edit Pasien')

@section('content')
<div class="space-y-6">
    <div class="flex items-center">
        <a href="{{ route('patients.index') }}" class="flex items-center text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pasien
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form id="editPatientForm" action="{{ route('patients.update', $patient) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nama Pasien -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                    <input type="text" name="nama_pasien" value="{{ $patient->nama_pasien }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Gender</option>
                        <option value="Laki-laki" {{ $patient->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $patient->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ $patient->nik }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ $patient->tanggal_lahir->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Jenis Perawatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Perawatan</label>
                    <select name="jenis_perawatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Jenis Perawatan</option>
                        <option value="Rawat Inap" {{ $patient->jenis_perawatan == 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                        <option value="Rawat Jalan" {{ $patient->jenis_perawatan == 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                        <option value="UGD" {{ $patient->jenis_perawatan == 'UGD' ? 'selected' : '' }}>UGD</option>
                    </select>
                </div>

                <!-- Waktu Periksa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Waktu Periksa</label>
                    <input type="datetime-local" name="waktu_periksa" value="{{ $patient->waktu_periksa->format('Y-m-d\TH:i') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Penyakit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Penyakit</label>
                    <select name="penyakit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Penyakit</option>
                        <option value="Demam" {{ $patient->penyakit == 'Demam' ? 'selected' : '' }}>Demam</option>
                        <option value="Flu" {{ $patient->penyakit == 'Flu' ? 'selected' : '' }}>Flu</option>
                        <option value="Batuk" {{ $patient->penyakit == 'Batuk' ? 'selected' : '' }}>Batuk</option>
                        <option value="Diare" {{ $patient->penyakit == 'Diare' ? 'selected' : '' }}>Diare</option>
                        <option value="Lainnya" {{ $patient->penyakit == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Obat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Obat</label>
                    <select name="obat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Obat</option>
                        <option value="Paracetamol" {{ $patient->obat == 'Paracetamol' ? 'selected' : '' }}>Paracetamol</option>
                        <option value="Amoxicillin" {{ $patient->obat == 'Amoxicillin' ? 'selected' : '' }}>Amoxicillin</option>
                        <option value="Ibuprofen" {{ $patient->obat == 'Ibuprofen' ? 'selected' : '' }}>Ibuprofen</option>
                        <option value="Lainnya" {{ $patient->obat == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Hasil Pemeriksaan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Hasil Pemeriksaan</label>
                <textarea name="hasil_pemeriksaan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ $patient->hasil_pemeriksaan }}</textarea>
            </div>

            <div class="flex justify-start space-x-4">
                <button type="button" onclick="confirmUpdate()" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update
                </button>
                <a href="{{ route('patients.show', $patient) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmUpdate() {
    Swal.fire({
        title: 'Konfirmasi Perubahan Data',
        text: "Apakah Anda yakin ingin mengubah data pasien ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editPatientForm').submit();
        }
    });
}
</script>
@endpush 