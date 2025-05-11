@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Notifikasi</h1>
    <div class="grid grid-cols-4 gap-6">
        {{-- Sidebar Notifikasi --}}
        <div class="col-span-1 bg-white shadow rounded-lg overflow-y-auto max-h-[600px]">
            <ul>
                @foreach ($notifications as $item)
                    <li class="border-b">
                        <a href="{{ route('notifications.show', $item->id) }}" class="block px-4 py-3 {{ $item->id === $notif->id ? 'bg-blue-100 text-blue-900 font-semibold' : 'text-gray-700 hover:bg-blue-50' }}">
                            <div class="flex justify-between items-center">
                                <span class="text-sm">{{ $item->title }}</span>
                                @if (is_null($item->read_at))
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Detail Notifikasi --}}
        <div class="col-span-3 bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">{{ $notif->title }}</h2>
            <div class="text-sm text-gray-700 leading-relaxed">
                {!! $notif->message !!}
            </div>

            <div class="mt-4">
                <p class="text-xs text-gray-500">Dikirim pada: {{ $notif->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
