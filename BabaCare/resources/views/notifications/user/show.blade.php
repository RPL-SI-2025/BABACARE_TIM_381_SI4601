@extends('landing_page_user')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Detail Notifikasi</h1>
    <div class="row">
        {{-- Sidebar Notifikasi --}}
        <div class="col-md-4">
            <div class="list-group">
                @foreach ($notifications as $notif)
                    <a href="{{ route('notifications.show', $notif->id) }}" 
                       class="list-group-item list-group-item-action 
                       {{ $notif->id === $notification->id ? 'active' : '' }}">
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

        {{-- Konten Detail --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $notification->data['title'] ?? '-' }}</h5>
                    <p class="card-text">{{ $notification->data['message'] ?? '-' }}</p>
                    @if(isset($notification->data['time']) && isset($notification->data['title']) && (Str::contains($notification->data['title'], 'Reminder') || Str::contains($notification->data['title'], 'Vaksinasi')))
                        <p class="card-text"><strong>Jam:</strong> {{ $notification->data['time'] }}</p>
                    @endif
                    <p class="text-muted">Dikirim pada: {{ $notification->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
