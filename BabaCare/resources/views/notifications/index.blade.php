@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Pusat Notifikasi</h1>
    <div class="grid grid-cols-4 gap-6">
        {{-- Sidebar Notifikasi --}}
        <div class="col-span-1 bg-white shadow rounded-lg overflow-y-auto max-h-[600px]">
            <ul>
                @foreach ($notifications as $notif)
                    <li class="border-b">
                        <a href="{{ route('notifications.show', $notif->id) }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50">
                            <div class="flex justify-between items-center">
                                <span class="text-sm">{{ $notif->title }}</span>
                                @if (is_null($notif->read_at))
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Pesan Default --}}
        <div class="col-span-3 bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Selamat datang di Pusat Notifikasi</h2>
            <div class="text-sm text-gray-700 leading-relaxed">
                <p>Pilih salah satu notifikasi dari daftar di sebelah kiri untuk melihat detail informasinya.</p>
                <p class="mt-2">Anda dapat melihat judul, isi pesan lengkap, serta waktu notifikasi dikirimkan.</p>
                <p class="mt-2">Notifikasi yang belum dibaca akan ditandai dengan titik merah.</p>
            </div>
        </div>
    </div>
</div>
@endsection
