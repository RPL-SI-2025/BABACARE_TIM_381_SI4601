@extends('landing_page_user')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Pusat Notifikasi</h1>
    <div class="row">
        {{-- Sidebar Notifikasi --}}
        <div class="col-md-4">
            <div class="list-group">
                @foreach ($notifications as $notif)
                    <a href="{{ route('notifications.show', $notif->id) }}" 
                       class="list-group-item list-group-item-action 
                       {{ isset($notification) && $notif->id === $notification->id ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $notif->data['title'] ?? '-' }}</span>
                            @if (is_null($notif->read_at))
                                <span class="badge bg-danger rounded-pill">●</span>
                            @endif
                        </div>
                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat datang di Pusat Notifikasi</h5>
                    <p class="card-text">Pilih notifikasi dari daftar untuk melihat detailnya.</p>
                    <p class="card-text">Titik merah berarti notifikasi belum dibaca.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
