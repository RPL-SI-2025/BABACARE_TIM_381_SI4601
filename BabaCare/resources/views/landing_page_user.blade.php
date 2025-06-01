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
            z-index: 9999;
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
        /* Custom styles for notification dropdown */
        #dropdownNotifMenu {
            min-width: 350px;
            max-height: 500px;
            overflow-y: auto;
            right: 0;
            left: auto;
        }
        #dropdownNotifMenu .notification-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        #dropdownNotifMenu .notification-item:hover {
            background-color: #f8f9fa;
        }
        #dropdownNotifMenu .notification-time {
            font-size: 0.75rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column align-items-center py-4">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" width="90" class="mb-5">
            <a href="{{ route('appointments.create') }}" class="nav-link mb-4 text-center">
                <i class="fa-solid fa-file-circle-plus fa-2x mb-2"></i>
                <div>Pemeriksaan</div>
            </a>
            <a href="{{ route('vaccination.create') }}" class="nav-link mb-4 text-center">
                <i class="fa-solid fa-file-circle-plus fa-2x mb-2"></i>
                <div>Vaksin dan Imunisasi</div>
            </a>
            <a href="{{ route('feedback.form') }}" class="nav-link text-center">
                <i class="fa-regular fa-comments fa-2x mb-2"></i>
                <div>Feedback</div>
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 position-relative" style="min-height: 100vh;">
            <!-- Profile & Notification -->
            <div class="position-absolute top-0 end-0 p-4 d-flex align-items-center" style="z-index: 20;">
                <!-- Notification Dropdown -->
                <div class="dropdown me-3">
                    <button class="btn position-relative p-0" id="dropdownNotifButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-bell fa-lg" style="color: #95A5A6;"></i>
                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                            <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="dropdownNotifMenu" aria-labelledby="dropdownNotifButton">
                        <li><div class="p-3 border-bottom fw-bold">Notifikasi</div></li>
                        @if(auth()->check() && auth()->user()->notifications->count() > 0)
                            @foreach(auth()->user()->notifications->take(5) as $notification)
                                <li>
                                    <a href="{{ route('notifications.show', $notification->id) }}" class="dropdown-item notification-item">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-bell me-2 mt-1 text-primary"></i>
                                            <div>
                                                <div class="fw-medium">{{ $notification->data['title'] ?? 'Notifikasi' }}</div>
                                                <div class="small">{{ $notification->data['message']  ?? '' }} Jam {{ $notification->data['time']  ?? '' }}</div>
                                                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><div class="dropdown-item text-center py-3 text-muted">Tidak ada notifikasi</div></li>
                        @endif
                        <li><div class="p-2 border-top text-center">
                            <a href="{{ route('notifications.index') }}" class="text-primary small">Lihat semua notifikasi</a>
                        </div></li>
                    </ul>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" role="button" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUserButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user fa-lg" style="color: #34495E;"></i>
                        <span class="ms-2" style="color: #34495E;">{{ Auth::user()->name ?? 'User' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" id="dropdownUserMenu" aria-labelledby="dropdownUserButton">
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

            <div>
                @hasSection('content')
                    @yield('content')
                @else
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
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Notification polling and display
        function fetchNotifications() {
            fetch("{{ route('notifications.poll') }}")
                .then(response => response.json())
                .then(data => {
                    // Update badge
                    const badge = document.querySelector('#dropdownNotifButton span');
                    if (data.count > 0) {
                        if (badge) {
                            badge.innerText = data.count;
                        } else {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full';
                            newBadge.innerText = data.count;
                            document.getElementById('dropdownNotifButton').appendChild(newBadge);
                        }
                    } else if (badge) {
                        badge.remove();
                    }

                    // Update dropdown menu
                    const container = document.getElementById('dropdownNotifMenu');
                    let html = `<div class="p-4 border-b font-semibold">Notifikasi</div>`;

                    if (data.notifications.length === 0) {
                        html += `<div class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi baru.</div>`;
                    } else {
                        data.notifications.forEach(notif => {
                            html += `
                                <div class="px-4 py-2 hover:bg-gray-100 text-sm text-gray-900 font-medium">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-bell mt-1"></i>
                                        <div>
                                            <a href="/notifications/${notif.id}" class="block">
                                                <div>${notif.title}</div>
                                                <div class="text-xs text-gray-500">${notif.message}</div>
                                                <div class="text-xs text-gray-400">${notif.time} • ${notif.created_at}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    html += `<div class="border-t p-2 text-center">
                        <a href="{{ route('notifications.index') }}" class="text-blue-500 text-sm hover:underline">Lihat semua</a>
                    </div>`;

                    container.innerHTML = html;
                });
        }
        // Check for new notifications to show in SweetAlert
        let lastNotifiedId = null;

        function checkNewNotification() {
            fetch("{{ route('notifications.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.has_new && data.id !== lastNotifiedId) {
                        lastNotifiedId = data.id;

                        // Show SweetAlert
                        showNotificationSwal(data);

                        // Mark as read
                        if (data.id) {
                            fetch("{{ url('/notifications') }}/" + data.id + "/read", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            });
                        }
                    }
                });
        }

        // Unified SweetAlert function for all notifications
        function showNotificationSwal(notif) {
            // Support both {data: {...}} and flat {...} notification objects
            let data = notif && notif.data ? notif.data : notif || {};
            // Fallback to notif.title/message/time if not present in data
            const title = data.title || notif.title || 'Notifikasi';
            const message = data.message || notif.message || '-';
            const time = data.time || notif.time || '';
            // Only show Jam for reminders/vaccinations with time
            const showTime = title && (title.includes('Reminder') || title.includes('Vaksinasi')) && time;
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                iconHtml: '<i class="fa fa-bell"></i>',
                title: `<strong>${title}</strong>`,
                html: `<b>Bapak/Ibu {{ auth()->user()->name }}</b><br>${message}${showTime ? ', Jam: <b>' + time + '</b>' : ''}`,
                showConfirmButton: true,
                timer: 60000,
                timerProgressBar: true,
                didOpen: () => {
                    const icon = Swal.getIcon();
                    if (icon) {
                        icon.innerHTML = '<i class="fas fa-calendar-alt" style="color: #3085d6;"></i>';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(auth()->check() && auth()->user()->unreadNotifications->isNotEmpty())
                const notif = @json(auth()->user()->unreadNotifications->first());
                showNotificationSwal(notif);
                // Mark as read
                if ((notif && notif.id) || (notif && notif.data && notif.data.id)) {
                    const id = notif.id || notif.data.id;
                    fetch("{{ url('/notifications') }}/" + id + "/read", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                }
            @endif

            // Start polling
            setInterval(fetchNotifications, 20000);
            setInterval(checkNewNotification, 20000);
            fetchNotifications();
        });
    </script>

    @stack('scripts')

    @if(session('toast'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="fixed bottom-4 right-4 bg-white border border-gray-300 shadow-xl rounded-xl px-4 py-3 text-sm text-gray-800 z-50"
        >
            <strong>{{ session('toast')['title'] }}</strong>
            <div>{{ session('toast')['message'] }}</div>
        </div>
    @endif
</body>
</html>