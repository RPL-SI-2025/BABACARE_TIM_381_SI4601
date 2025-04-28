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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #F7F8FD;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            width: 100px; 
            min-height: 100vh; 
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .sidebar .nav-link { 
            color: #95A5A6; 
            font-size: 13px;
            transition: all 0.3s ease;
            padding: 15px 0;
        }
        .sidebar .nav-link:hover { 
            color: #34495E;
            transform: translateY(-2px);
        }
        .sidebar .nav-link i {
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }
        .profile-dropdown { 
            min-width: 200px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .profile-dropdown .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
        }
        .profile-dropdown .dropdown-item:hover {
            background-color: #F7F8FD;
            padding-left: 25px;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #E74C3C;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
        }
        .background-circle {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .contact-btn {
            transition: all 0.3s ease;
            border: 2px solid #34495E;
            padding: 10px 30px;
        }
        .contact-btn:hover {
            background-color: #34495E;
            color: white;
            transform: translateY(-2px);
        }
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background-color: rgba(255,255,255,0.8);
            text-align: center;
            font-size: 12px;
            color: #95A5A6;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column align-items-center py-4">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" width="90" class="mb-5">
            <a href="#" class="nav-link mb-4 text-center">
                <i class="fa-solid fa-file-circle-plus fa-2x mb-2"></i>
                <div>Pendaftaran</div>
            </a>
            <a href="#" class="nav-link text-center">
                <i class="fa-regular fa-comments fa-2x mb-2"></i>
                <div>Feedback</div>
            </a>
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1 position-relative" style="min-height: 100vh;">
            <!-- Profile & Notification -->
            <div class="position-absolute top-0 end-0 p-4 d-flex align-items-center" style="z-index: 10;">
                <a href="#" class="me-3 position-relative">
                    <i class="fa-regular fa-bell fa-lg" style="color: #95A5A6;"></i>
                    <span class="notification-badge">3</span>
                </a>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user fa-lg" style="color: #34495E;"></i>
                        <span class="ms-2" style="color: #34495E;">{{ Auth::user()->name ?? 'User' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.profile.edit') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Content -->
            <div class="d-flex flex-column justify-content-center align-items-start h-100" style="padding: 100px 0 0 120px;">
                <h1 class="fw-bold" style="font-size: 48px;">Puskesmas<br>Babagan Tarogong</h1>
                <p class="text-muted mb-4" style="font-size: 16px;">"Melayani dengan Amanah, Tulus, Adil dan Profesional"</p>
                <button class="btn contact-btn" style="font-size: 16px;">Contact Us</button>
            </div>
            <!-- Background Circle -->
            <div class="background-circle" style="position: absolute; right: 0; bottom: 0; z-index: 0;">
                <img src="{{ asset('storage/background_lingkaran.png') }}" alt="Illustration" style="max-width: 530px;">
            </div>
            <!-- Footer -->
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <i class="fas fa-phone me-2"></i> (021) 123-4567
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-envelope me-2"></i> info@babacare.com
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-map-marker-alt me-2"></i> Jl. Babagan No. 123, Tarogong
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>