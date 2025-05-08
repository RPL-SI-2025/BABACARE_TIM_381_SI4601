<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - BabaCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #F7F8FD; }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header i {
            font-size: 48px;
            color: #34495E;
            margin-bottom: 15px;
        }
        .form-control {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 5px;
        }
        .form-control:focus {
            border-color: #34495E;
            box-shadow: 0 0 0 0.2rem rgba(52, 73, 94, 0.25);
        }
        .btn-primary {
            background-color: #34495E;
            border-color: #34495E;
            padding: 10px 25px;
        }
        .btn-primary:hover {
            background-color: #2C3E50;
            border-color: #2C3E50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <i class="fas fa-user-circle"></i>
                <h2>Edit Profil</h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" placeholder="Nama" value="{{ old('name', $user->name) }}">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="age" placeholder="Umur" value="{{ old('age', $user->age) }}">
                        @error('age')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nik" placeholder="NIK" value="{{ old('nik', $user->nik) }}" maxlength="16">
                        @error('nik')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" name="gender">
                            <option value="">Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="date" class="form-control" name="birth_date" placeholder="Tanggal Lahir" value="{{ old('birth_date', $user->birth_date) }}">
                        @error('birth_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="disease_history" placeholder="Riwayat Penyakit" value="{{ old('disease_history', $user->disease_history) }}">
                        @error('disease_history')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" placeholder="Alamat Email" value="{{ old('email', $user->email) }}">
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address" placeholder="Alamat Rumah" value="{{ old('address', $user->address) }}">
                        @error('address')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" placeholder="Nomor WA" value="{{ old('phone', $user->phone) }}">
                        @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="allergy" placeholder="Alergi" value="{{ old('allergy', $user->allergy) }}">
                        @error('allergy')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2" style="font-size: 18px;">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 