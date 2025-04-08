<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabaCare - Landing Page Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head> 
<body style="background-color: #F7F8FD;">
    <div class="container-fluid">
        <div class="row">
            <div class="position-absolute top-0 start-0 p-5">
                <a class="navbar-brand" href="#">
                    <img src="storage/logo.png" alt="Logo" width="118" height="49.11">
                </a>
            </div>
            <nav class="col-auto bg-white shadow-sm p-3 d-flex flex-column justify-content-start position-fixed" style="height: 85vh; top: 15vh; width: 12.5%; overflow-y: auto; font-family: 'Roboto', sans-serif; min-height: 100vh;">
                <ul class="nav flex-column mt-5 w-100">
                    <li class="nav-item mb-4">
                        <a class="nav-link text-dark d-flex flex-column align-items-center text-center" href="#">
                            <img src="storage/dashboard.svg" alt="Dashboard" class="mb-2" style="width: 30px; height: 30px;">
                            <span style="color: #95A5A6; font-size: 13px">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item mb-4">
                        <a class="nav-link text-dark d-flex flex-column align-items-center text-center" href="#">
                            <img src="storage/tenaga_medis.svg" alt="TenagaMedis" class="mb-2" style="width: 30px; height: 30px;">
                            <span style="color: #95A5A6; font-size: 13px">Tenaga Medis</span>
                        </a>
                    </li>
                    <li class="nav-item mb-4">
                        <a class="nav-link text-dark d-flex flex-column align-items-center text-center" href="#">
                            <img src="storage/obat.svg" alt="Obat" class="mb-2" style="width: 30px; height: 30px;">
                            <span style="color: #95A5A6; font-size: 13px;">Data Obat</span>
                        </a>
                    </li>
                    <li class="nav-item mb-4">
                        <a class="nav-link text-dark d-flex flex-column align-items-center text-center" href="#">
                            <img src="storage/manajemen_data.svg" alt="ManajemenObat" class="mb-2" style="width: 30px; height: 30px;">
                            <span style="color: #95A5A6; font-size: 13px;">Manajemen Data</span>
                            <span style="color: #95A5A6; font-size: 13px;">Obat</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="top-right-icons position-fixed d-flex align-items-center" style="top: 20px; left: 1300px; gap: 50px; z-index: 9999;">
                <a class="position-relative" href="#">
                    <img src="storage/notifikasi.svg" alt="Notifikasi" style="width: 40px; height: 35px;">
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">3</span>
                </a>
                <a class="position-relative" href="#" style="text-decoration: none;">
                    <img src="storage/avatar.svg" alt="Profile" style="width: 40px; height: 40px;">
                    <span style="margin-left: 10px; font-size: 14px; color: #34495E;">Admin</span> 
                </a>
            </div>
            <main class="col-md-9 ms-auto col-lg-10 px-md-4 d-flex flex-column justify-content-center align-items-start py-5 position-relative pe-5" style="font-family: 'Roboto', sans-serif; min-height: 100vh;">
                <div class="ms-5 ps-5">
                    <h1 class="fw-bold" style="font-size: 52px">Puskesmas</h1>
                    <h1 class="fw-bold mb-2" style="font-size: 52px">Babagan Tarogong</h1>
                    <p class="text-muted mb-5" style="font-size: 16px">"Melayani dengan Amanah, Tulus, Adil dan Profesional"</p>
                    <button class="btn btn-outline-dark" style="font-size: 16px">Contact Us</button>
                </div>
                <div class="position-absolute bottom-0 end-0" style="z-index: -1;">
                    <img src="storage/background_lingkaran.png" alt="Illustration" class="img-fluid" style="max-width: 530px;">
                </div>
            </main>
        </div>
    </div>
</body>
</html>