<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabaCare - Landing Page User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #F7F8FD; font-family: 'Roboto', sans-serif;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm" style="min-height: 80px;">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand py-2" href="/">
                <img src="{{ asset('/storage/logo.png') }}" alt="Logo" width="118" height="49.11">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item me-4">
                        <a class="nav-link position-relative d-flex align-items-center justify-content-center" href="#" style="height: 40px;">
                            <img src="{{ asset('/storage/notifikasi.svg') }}" alt="Notifikasi" style="width: 30px; height: 30px;">
                            <span class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-2" href="#">
                            <img src="{{ asset('/storage/avatar.svg') }}" alt="Profile" style="width: 35px; height: 35px;">
                            <span style="margin-left: 10px; font-size: 14px; color: #34495E;">Admin</span> 
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-12 p-0">
                <nav class="bg-white shadow-sm p-3 d-flex flex-column" style="min-height: calc(100vh - 80px); overflow-y: auto; position: sticky; top: 80px;">
                    <ul class="nav flex-column mt-3 w-100">
                        <li class="nav-item mb-4">
                            <a class="nav-link d-flex flex-column align-items-center text-center" href="{{ route('appointments.create') }}" style="color: #95A5A6;">
                                <img src="{{ asset('/storage/pendaftaran.svg') }}" alt="Pendaftaran" class="mb-2" style="width: 35px; height: 35px;">
                                <span style="font-size: 13px;">Pendaftaran</span>
                            </a>
                        </li>
                        <li class="nav-item mb-4">
                            <a class="nav-link d-flex flex-column align-items-center text-center" href="#" style="color: #95A5A6;">
                                <img src="{{ asset('/storage/feedback.svg') }}" alt="Feedback" class="mb-2" style="width: 35px; height: 35px;">
                                <span style="font-size: 13px;">Feedback</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-12 px-md-4 py-5 position-relative">
                @hasSection('content')
                    @yield('content')
                @else
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-md-8 col-sm-12">
                                <h1 class="fw-bold" style="font-size: 52px;">Puskesmas</h1>
                                <h1 class="fw-bold mb-2" style="font-size: 52px;">Babagan Tarogong</h1>
                                <p class="text-muted mb-5" style="font-size: 16px;">"Melayani dengan Amanah, Tulus, Adil dan Profesional"</p>
                                <button class="btn btn-outline-dark" style="font-size: 16px;">Contact Us</button>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0" style="z-index: -1;">
                        <img src="{{ asset('/storage/background_lingkaran.png') }}" alt="Illustration" class="img-fluid" style="max-width: 530px;">
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Bootstrap responsive adjustments -->
    <script>
        // Adjust sidebar for mobile view
        function adjustLayout() {
            if (window.innerWidth < 992) {
                // For mobile view
                const sidebarNav = document.querySelector('.col-lg-2 nav');
                sidebarNav.style.position = 'static';
                sidebarNav.style.minHeight = 'auto';
                
                const navList = document.querySelector('.nav.flex-column');
                navList.classList.remove('flex-column');
                navList.classList.add('flex-row');
                navList.style.justifyContent = 'center';
                
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    item.style.marginRight = '20px';
                    item.style.marginBottom = '10px';
                });
            } else {
                // For desktop view
                const sidebarNav = document.querySelector('.col-lg-2 nav');
                sidebarNav.style.position = 'sticky';
                sidebarNav.style.minHeight = 'calc(100vh - 80px)';
                
                const navList = document.querySelector('.nav');
                if (!navList.classList.contains('navbar-nav')) { // Don't adjust the top navbar
                    navList.classList.remove('flex-row');
                    navList.classList.add('flex-column');
                    navList.style.justifyContent = '';
                }
                
                const navItems = document.querySelectorAll('.col-lg-2 .nav-item');
                navItems.forEach(item => {
                    item.style.marginRight = '0';
                    item.style.marginBottom = '1rem';
                });
            }
        }

        // Run on page load and resize
        window.onload = adjustLayout;
        window.onresize = adjustLayout;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>