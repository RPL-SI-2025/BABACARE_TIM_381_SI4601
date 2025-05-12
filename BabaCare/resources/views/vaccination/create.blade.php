@extends('landing_page_user')

@section('title', 'Pendaftaran Vaksin & Imunisasi')

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

    <form id="vaccinationRegistrationForm" action="{{ route('vaccination.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="type" class="form-label">Select Category</label>
            <select id="type" name="type" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="vaccine" {{ old('type') == 'vaccine' ? 'selected' : '' }}>Vaccine</option>
                <option value="immunization" {{ old('type') == 'immunization' ? 'selected' : '' }}>Immunization</option>
            </select>
            @error('type')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="vaccine_id" class="form-label">Jenis Vaksin</label>
            <select id="vaccine_id" name="vaccine_id" class="form-select" required>
                <option value="">-- Pilih Jenis Vaksin --</option>
                @foreach($vaccines as $vaccine)
                    <option value="{{ $vaccine->id }}" data-type="{{ $vaccine->type }}" {{ old('vaccine_id') == $vaccine->id ? 'selected' : '' }}>
                        {{ $vaccine->name }}
                    </option>
                @endforeach
            </select>
            @error('vaccine_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="vaccination_date" class="form-label">Tanggal Vaksinasi</label>
            <input type="date" id="vaccination_date" name="vaccination_date"
                   value="{{ old('vaccination_date', date('Y-m-d')) }}"
                   min="{{ date('Y-m-d') }}"
                   class="form-control" required>
            @error('vaccination_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="vaccination_time" class="form-label">Waktu Vaksinasi</label>
            <input type="time" id="vaccination_time" name="vaccination_time"
                   value="{{ old('vaccination_time') }}"
                   class="form-control" required>
            @error('vaccination_time')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="allergies" class="form-label">Riwayat Alergi</label>
            <textarea id="allergies" name="allergies" rows="4"
                      class="form-control">{{ old('allergies') }}</textarea>
            @error('allergies')
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
    document.getElementById('type').addEventListener('change', function() {
        const selectedType = this.value;
        const vaccineSelect = document.getElementById('vaccine_id');
        const options = vaccineSelect.querySelectorAll('option');
        
        vaccineSelect.value = '';
        
        options.forEach(option => {
            if (option.value === '') return;
            
            if (selectedType === '' || option.dataset.type === selectedType) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        if (typeSelect.value) {
            typeSelect.dispatchEvent(new Event('change'));
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
                document.getElementById('vaccinationRegistrationForm').submit();
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