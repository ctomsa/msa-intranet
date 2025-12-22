<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use Carbon\Carbon;

class MeetingRoomController extends Controller
{
    public function index()
    {
        $rooms = MeetingRoom::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('meeting-rooms.index', compact('rooms'));
    }

public function show(MeetingRoom $room)
{
    // week=YYYY-MM-DD (любой день недели), показываем неделю Пн..Пт
    $weekParam = request('week');

    $weekStart = $weekParam
        ? \Carbon\Carbon::parse($weekParam)->startOfWeek(\Carbon\Carbon::MONDAY)
        : \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);

    $weekEndExclusive = (clone $weekStart)->addDays(5); // Пн..Пт (не включая Сб)

    $days = collect(range(0, 4))->map(fn ($i) => (clone $weekStart)->addDays($i));

    $bookings = $room->bookings()
        ->whereDate('date', '>=', $weekStart->toDateString())
        ->whereDate('date', '<',  $weekEndExclusive->toDateString())
        ->orderBy('date')
        ->orderBy('start_time')
        ->get();

    return view('meeting-rooms.show', [
        'room' => $room,
        'days' => $days,
        'bookings' => $bookings,
        'weekStart' => $weekStart,
        'prevWeek' => (clone $weekStart)->subWeek(),
        'nextWeek' => (clone $weekStart)->addWeek(),
    ]);
}
}
