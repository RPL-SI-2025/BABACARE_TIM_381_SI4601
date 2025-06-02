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
                <img src="{{ asset('storage/logo.png') }}" alt="BabaCare" class="h-10">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col space-y-8 mt-28">
            <a href="{{ route('tenaga_medis.index') }}"
                class="flex flex-col items-center text-gray-700 hover:text-black">
                <img src="{{ asset('storage/tenaga_medis.svg') }}" alt="Tenaga Medis" class="w-8 h-8 mb-2">
                <span class="text-xs text-gray-500">Tenaga Medis</span>
            </a>

            <a href="/dashboarddataobat"
                class="flex flex-col items-center text-gray-700 hover:text-black">
                <img src="{{ asset('storage/obat.svg') }}" alt="Dashboard Data Obat" class="w-8 h-8 mb-2">
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
        <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="flex items-center justify-between bg-white shadow px-6 py-8 relative">
            <div></div> <!-- Placeholder untuk center header -->
            <div class="flex items-center space-x-8 absolute right-10 top-4">
                <!-- Notification Dropdown -->
                <div class="relative">
                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                    <button id="dropdownNotifButton" class="relative text-gray-500 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-bell text-xl"></i>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const notifBtn = document.getElementById('dropdownNotifButton');
                            const notifMenu = document.getElementById('dropdownNotifMenu');
                            if (notifBtn && notifMenu) {
                                notifBtn.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    notifMenu.classList.toggle('hidden');
                                });
                                document.addEventListener('click', function(e) {
                                    if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                                        notifMenu.classList.add('hidden');
                                    }
                                });
                                // Mark notification as read on click
                                notifMenu.querySelectorAll('a[href*="notifications/show"]').forEach(function(link) {
                                    link.addEventListener('click', function(ev) {
                                        const notifId = this.href.split('/').pop();
                                        fetch(`/notifications/${notifId}/read`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json'
                                            }
                                        });
                                    });
                                });
                            }
                        });
                    </script>
                    <div id="dropdownNotifMenu" class="hidden absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto bg-white rounded-md shadow-lg z-50">
                        <div class="p-4 border-b font-semibold">Notifikasi</div>
                        @forelse(auth()->user()->notifications->take(5) as $notif)
                            <div class="px-4 py-2 hover:bg-gray-100 text-sm border-b border-gray-100 {{ $notif->read_at ? 'text-gray-500' : 'text-gray-900 font-medium' }}">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-bell mt-1 text-blue-500"></i>
                                    <div style="word-break: break-word; white-space: normal;">
                                        <a href="{{ route('notifications.show', $notif->id) }}" class="block">
                                            <div class="font-medium">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $notif->data['message'] ?? '' }}
                                                @php
                                                    $title = $notif->data['title'] ?? '';
                                                    $time = $notif->data['time'] ?? '';
                                                    $showTime = $title && Str::contains($title, 'Reminder') && $time;
                                                @endphp
                                                @if($showTime)
                                                    , Jam: <b>{{ $time }}</b>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi baru.</div>
                        @endforelse
                        <div class="border-t p-2 text-center">
                            <a href="{{ route('notifications.index') }}" class="text-blue-500 text-sm hover:underline">Lihat semua</a>
                        </div>
                    </div>
                </div>
                <!-- Profile -->
                <a href="#" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/avatar.svg') }}" alt="Profile" class="w-8 h-8 rounded-full">
                    <span class="text-gray-700 text-sm font-semibold">Admin</span>
                </a>
            </div>
        </header>
        <!-- Page Content -->
        <main class="relative flex flex-col justify-center items-center" style="font-family: 'Roboto', sans-serif; min-height: 100vh; position: relative;">
            <!-- Teks tengah -->
            <div class="ms-5 ps-5">
                <h1 class="fw-bold" style="font-size: 52px;">Puskesmas</h1>
                <h1 class="fw-bold mb-2" style="font-size: 52px;">Babakan Tarogong</h1>
                <p class="text-muted mb-5" style="font-size: 16px;">"Melayani dengan Amanah, Tulus, Adil dan Profesional"</p>
                <button class="btn btn-outline-dark" style="font-size: 16px;">Contact Us</button>
            </div>

            <!-- Gambar kanan bawah -->
            <img src="{{ asset('storage/background_lingkaran.png') }}" alt="Illustration"
                class="absolute bottom-0 right-0" style="max-width: 530px; z-index: 0;">
        </main>

    </div>

@stack('scripts')
<!-- SweetAlert2 Notifikasi -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            });
        });
    </script>
@endif
<script>
    // Unified SweetAlert function for all notifications
    function showNotificationSwal(notif) {
        let data = notif && notif.data ? notif.data : notif || {};
        const title = data.title || notif.title || 'Notifikasi';
        const message = data.message || notif.message || '-';
        const time = data.time || notif.time || '';
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
    // Check for new notifications to show in SweetAlert
    let lastNotifiedId = null;
    function checkNewNotification() {
        fetch("{{ route('notifications.latest') }}")
            .then(response => response.json())
            .then(data => {
                if (data.has_new && data.id !== lastNotifiedId) {
                    lastNotifiedId = data.id;
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
    // Initial check for unread notifications
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
        // Optionally, set interval polling for new notifications
        setInterval(checkNewNotification, 30000);
    });
</script>
</body>
</html>
