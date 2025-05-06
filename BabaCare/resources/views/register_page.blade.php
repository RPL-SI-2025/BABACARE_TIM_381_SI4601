<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BabaCare</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">

    <div class="flex justify-center items-center min-h-screen">
        <div class="flex bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-7xl">
            <!-- Form Section -->
            <div class="w-1/2 bg-gray-200 flex items-center justify-center">
                <img src="{{ asset('https://idalamat.com/images/addresses/2707221-upt-puskesmas-babakan-tarogong-bandung-jawa-barat.jpg') }}" alt="Puskesmas" class="w-full h-full object-cover" />
            </div>
            <div class="w-1/2 p-6">
                <h2 class="text-3xl font-semibold text-gray-800 mb-6">Registrasi Akun</h2>

                <!-- Registration Form -->
                <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                    @csrf
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700">Nama Depan</label>
                        <input type="text" name="first_name" id="first_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700">Nama Belakang</label>
                        <input type="text" name="last_name" id="last_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                            Daftar
                        </button>
                        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                            Sudah punya akun? Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to handle form validation, success and redirect to login page -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submit default

            // Mendapatkan nilai input form
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validasi form (cek jika nama, email, dan password sudah terisi)
            if (!firstName || !lastName || !email || !password || !passwordConfirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Pastikan semua data sudah diisi.',
                });
            } else if (password !== passwordConfirmation) {
                // Validasi jika password dan konfirmasi password tidak sama
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Password dan konfirmasi password tidak sama.',
                });
            } else if (password.length < 8) {
                // Validasi panjang password minimal 8 karakter
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Password harus memiliki minimal 8 karakter.',
                });
            } else if (!/[a-zA-Z]/.test(password) || !/[0-9]/.test(password)) {
                // Validasi bahwa password harus mengandung huruf dan angka
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Password harus mengandung huruf dan angka.',
                });
            } else {
                // Jika validasi berhasil, submit form dan tampilkan SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil',
                    text: 'Akun Anda telah berhasil dibuat!',
                    confirmButtonText: 'Lanjutkan ke Login'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke halaman login setelah konfirmasi
                        document.getElementById('registerForm').submit();
                    }
                });

            }
        });
    </script>

</body>
</html>
