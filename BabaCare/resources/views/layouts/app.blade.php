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
                        <span>Medical Record Pasien</span>
                    </a>
                    <a href="{{ route('referrals.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('referrals.*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-user w-5 h-5 mr-2"></i>
                        <span>Rujukan dan Resep Obat</span>
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
                        <div class="relative">
                            <button id="dropdownUserButton" class="flex items-center focus:outline-none">
                                <i class="fas fa-user text-xl mr-2"></i>
                                <span class="text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="dropdownUserMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Pengaturan
                                </a>
                                <div class="border-t my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
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
    <script>
        // Script untuk toggle dropdown
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('dropdownUserButton');
            const menu = document.getElementById('dropdownUserMenu');
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function () {
                menu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>