@extends('layouts.app')

@section('content')
<style>
    .mr-room-card {
        display: block;
        text-decoration: none;
        color: inherit;
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(17,24,39,.06);
        box-shadow: 0 12px 40px rgba(16,24,40,.08);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .mr-room-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 50px rgba(16,24,40,.12);
        border-color: rgba(106,91,255,.35);
        cursor: pointer;
    }
</style>
<div class="max-w-7xl mx-auto px-6 py-6 space-y-6">
@php
    $u = auth()->user();
    $isAdmin =
        $u &&
        (
            ($u->is_admin ?? false) ||
            ($u->isAdmin ?? false) ||
            (method_exists($u, 'isAdmin') && $u->isAdmin())
        );
@endphp
    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-sm text-blue-800">
        ⚠️ Бронирование переговорных осуществляется администратором
    </div>

    <h1 class="text-2xl font-semibold">Переговорки</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@foreach($rooms as $room)
<a href="{{ route('meeting-rooms.show', $room) }}"
   class="mr-room-card space-y-3">
	        <div class="flex justify-between items-start">
            <div>
                <div class="text-lg font-medium">{{ $room->name }}</div>
                @if($room->capacity)
                    <div class="text-sm text-slate-500">
                        До {{ $room->capacity }} человек
                    </div>
                @endif
            </div>

            @if($isAdmin)
                <button type="button"
                        title="Добавить встречу"
                        onclick="event.preventDefault(); event.stopPropagation(); window.location='{{ route('admin.meeting-bookings.create', ['room_id' => $room->id]) }}';"
                        style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:10px;background:#6A5BFF;color:#fff;border:0;box-shadow:0 10px 24px rgba(106,91,255,.22);cursor:pointer;"
                >
                    +
                </button>
            @endif
        </div>

        <div class="text-sm text-slate-600">
            {{ $room->bookings->count() }} встреч на этой неделе
        </div>
    </a>
@endforeach
    </div>

</div>
@endsection
