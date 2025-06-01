<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabaCare - Landing Page Admin @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-56 bg-white flex flex-col items-center py-8 shadow-md relative">
        <!-- Logo -->
        <div class="absolute top-5 left-5">
            <a href="#">
                <img src="{{ asset('images/logo.png') }}" alt="BabaCare" class="h-10" />
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col space-y-8 mt-28">
            <a href="#"
               class="flex flex-col items-center text-gray-700 hover:text-black ">
                <img src="{{ asset('storage/dashboard.svg') }}" alt="Dashboard" class="w-8 h-8 mb-2">
                <span class="text-xs text-gray-500">Dashboard</span>
            </a>

            <a href="#"
               class="flex flex-col items-center text-gray-700 hover:text-black">
                <img src="{{ asset('storage/tenaga_medis.svg') }}" alt="Tenaga Medis" class="w-8 h-8 mb-2">
                <span class="text-xs text-gray-500">Tenaga Medis</span>
            </a>

            <a href="{{ route('obats.dashboarddataobat') }}"
               class="flex flex-col items-center text-gray-700 hover:text-black">
                <img src="{{ asset('storage/obat.svg') }}" alt="Data Obat" class="w-8 h-8 mb-2">
                <span class="text-xs text-gray-500">Dashboard Data Obat</span>
            </a>

            <a href="/obats"
               class="flex flex-col items-center text-gray-700 hover:text-black">
                <img src="{{ asset('storage/manajemen_data.svg') }}" alt="Manajemen Data Obat" class="w-8 h-8 mb-2">
                <span class="text-xs text-gray-500">Manajemen Data Obat</span>
            </a>

            <a href="{{ route('admin.feedback.dashboard') }}"
               class="flex flex-col items-center text-gray-700 hover:text-black">
                <i class="fas fa-chart-pie w-8 h-8 mb-2"></i>
                <span class="text-xs text-gray-500">Feedback Dashboard</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="flex items-center justify-between bg-white shadow px-6 py-8 relative">
            <div></div> <!-- Placeholder untuk center header -->

            <div class="flex items-center space-x-8 absolute right-10 top-4">
                <a href="#" class="relative">
                    <img src="{{ asset('storage/notifikasi.svg') }}" alt="Notifikasi" class="w-8 h-8">
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">3</span>
                </a>
                <a href="#" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/avatar.svg') }}" alt="Profile" class="w-8 h-8 rounded-full">
                    <span class="text-gray-700 text-sm font-semibold">Admin</span>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
