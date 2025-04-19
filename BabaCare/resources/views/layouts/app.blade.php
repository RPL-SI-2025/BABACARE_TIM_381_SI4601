<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabaCare - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="BabaCare" class="h-8" />
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-6 py-4 space-y-2">
                    <a href="{{ route('landing') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('landing') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-home w-5 h-5 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('patients.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('patients.*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-user w-5 h-5 mr-2"></i>
                        <span>Management Pasien</span>
                    </a>
                    <a href="{{ route('appointments.create') }}" 
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('appointments.*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-calendar-plus w-5 h-5 mr-2"></i>
                        <span>Pendaftaran</span>
                    </a>
                    <a href="{{ route('reports.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-2"></i>
                        <span>Laporan Data Pasien</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-4 py-6 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header')</h1>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-600">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name=Dokter&background=0D8ABC&color=fff" alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="text-gray-700">Dokter</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
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