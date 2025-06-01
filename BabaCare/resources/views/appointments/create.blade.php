@extends('landing_page_user')

@section('title', 'Pendaftaran Pemeriksaan')

@section('content')
<div class="card shadow-sm p-4 mb-5 bg-white rounded">

    @if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="createAppointmentForm" action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tanggal_reservasi" class="form-label">Tanggal Reservasi</label>
            <input type="date" id="tanggal_reservasi" name="tanggal_reservasi"
                   value="{{ old('tanggal_reservasi', date('Y-m-d')) }}"
                   class="form-control" required>
            @error('tanggal_reservasi')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                   value="{{ old('tanggal_pelaksanaan') }}"
                   min="{{ date('Y-m-d') }}"
                   class="form-control" required>
            @error('tanggal_pelaksanaan')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="waktu_pelaksanaan" class="form-label">Waktu Pelaksanaan</label>
            <input type="time" id="waktu_pelaksanaan" name="waktu_pelaksanaan"
                   value="{{ old('waktu_pelaksanaan') }}"
                   class="form-control" required>
            @error('waktu_pelaksanaan')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="keluhan_utama" class="form-label">Keluhan Utama</label>
            <textarea id="keluhan_utama" name="keluhan_utama" rows="4"
                      class="form-control" required>{{ old('keluhan_utama') }}</textarea>
            @error('keluhan_utama')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="button" onclick="confirmSubmit()" class="btn btn-primary flex-fill">
                Daftar
            </button>
            <a href="{{ route('user.landing') }}" class="btn btn-outline-secondary flex-fill">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('tanggal_reservasi').addEventListener('change', function() {
        document.getElementById('tanggal_pelaksanaan').min = this.value;
        
        const pelaksanaanInput = document.getElementById('tanggal_pelaksanaan');
        if (pelaksanaanInput.value && pelaksanaanInput.value < this.value) {
            pelaksanaanInput.value = this.value;
        }
    });

    function confirmSubmit() {
        Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            text: "Apakah data yang Anda masukkan sudah benar?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Daftar Sekarang',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('createAppointmentForm').submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonText: 'Oke'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        confirmButtonText: 'Oke'
    });
    @endif
</script>
@endpush

