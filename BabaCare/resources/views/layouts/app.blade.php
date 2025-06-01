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
                    <div class="relative">
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp
                        <button id="dropdownNotifButton" class="relative text-gray-500 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>
                        <div id="dropdownNotifMenu" class="hidden absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto bg-white rounded-md shadow-lg z-50">
                            <div class="p-4 border-b font-semibold">Notifikasi</div>
                            
                            <!-- Menampilkan daftar notifikasi untuk user yang login -->
                            @forelse(auth()->user()->notifications->take(5) as $notif) 
                                <div class="px-4 py-2 hover:bg-gray-100 text-sm {{ $notif->is_read ? 'text-gray-500' : 'text-gray-900 font-medium' }}">
                                    <div class="flex items-start gap-2">
                                        @if($notif->icon ?? false)
                                            <i class="{{ $notif->icon }} mt-1"></i> <!-- Menampilkan ikon jika ada -->
                                        @endif
                                        <div>
                                            <a href="{{ route('notifications.show', $notif->id) }}" class="block">
                                            <div>{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                                            <div class="text-xs text-gray-500">{{ $notif->data['message'] ?? '' }} {{ $notif->data['time'] ?? '' }}</div>
                                            <div class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi baru.</div>
                            @endforelse
                            
                            <!-- Link untuk melihat semua notifikasi -->
                            <div class="border-t p-2 text-center">
                                <a href="{{ route('notifications.index') }}" class="text-blue-500 text-sm hover:underline">Lihat semua</a>
                            </div>
                        </div>
                    </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle Dropdown User
        const btnUser = document.getElementById('dropdownUserButton');
        const menuUser = document.getElementById('dropdownUserMenu');

        btnUser.addEventListener('click', function (e) {
            e.stopPropagation();
            menuUser.classList.toggle('hidden');
        });

        // Toggle Dropdown Notifikasi
        const btnNotif = document.getElementById('dropdownNotifButton');
        const menuNotif = document.getElementById('dropdownNotifMenu');

        btnNotif.addEventListener('click', function (e) {
            e.stopPropagation();
            menuNotif.classList.toggle('hidden');
        });

        // Klik di luar dropdown menutup semua dropdown
        document.addEventListener('click', function (e) {
            menuUser.classList.add('hidden');
            menuNotif.classList.add('hidden');
        });
    });
    </script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(auth()->check() && auth()->user()->unreadNotifications->isNotEmpty())
            const notif = @json(auth()->user()->unreadNotifications->first());
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                iconHtml: '<i class="fa fa-bell"></i>',
                title: `<strong>REMINDER JANJI TEMU</strong>`,
                html: `<b>Bapak/Ibu {{ auth()->user()->name }}</b><br>Anda memiliki janji temu pada jam <b>${notif.data.time}</b>`,
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

            // Setelah menampilkan, tandai sebagai dibaca via AJAX atau reload
            fetch("{{ route('notifications.markAsRead', auth()->user()->unreadNotifications->first()->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        @endif
    </script>

    <script>
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
                                            <a href="${notif.url}" class="block">
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

        // Poll setiap 20 detik
        setInterval(fetchNotifications, 20000);
        fetchNotifications();
    </script>

    <script>
        let lastNotifiedId = null;

        function checkNewNotification() {
            fetch("{{ route('notifications.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.has_new && data.id !== lastNotifiedId) {
                        lastNotifiedId = data.id;

                        // Tampilkan SweetAlert
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            iconHtml: '<i class="fa fa-bell"></i>',
                            title: `<strong>${data.title}</strong>`,
                            html: `<b>Bapak/Ibu {{ auth()->user()->name }}</b><br>Anda memiliki janji temu pada jam <b>${data.time}</b>`,
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

                        // Tandai sebagai dibaca
                        fetch(`/notifications/${data.id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    }
                });
        }

        // Cek setiap 20 detik
        setInterval(checkNewNotification, 20000);
        checkNewNotification();
    </script>

</body>
</html>