<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - BabaCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Kolom Gambar -->
        <div class="w-1/2 hidden md:block">
            <img src="{{ asset('images/login_image.png') }}" alt="Puskesmas Babakan Tarogong" class="h-full w-full object-cover">
        </div>

        <!-- Kolom Form Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-md">
                <h2 class="text-center text-2xl font-bold text-gray-900">Selamat Datang</h2>
                <p class="text-center text-sm text-gray-600">Masukkan email dan password dulu yaa</p>
                <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="rounded-md shadow-sm space-y-4">
                        <div>
                            <input id="email" name="email" type="email" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                   placeholder="Email">
                        </div>
                        <div>
                            <input id="password" name="password" type="password" required
                                   class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                   placeholder="Password">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Login
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Tidak Punya Akun?
                            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                Registrasi Akun
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
