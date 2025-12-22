<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeetingBooking;
use App\Models\MeetingRoom;
use App\Services\MeetingBookingService;
use Illuminate\Http\Request;

class MeetingBookingController extends Controller
{
    public function index()
    {
        // на будущее: список всех бронирований
        $bookings = MeetingBooking::with('room')
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->paginate(50);

        return view('admin.meeting-bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = MeetingRoom::where('is_active', true)->orderBy('id')->get();

        return view('admin.meeting-bookings.create', [
            'rooms' => $rooms,
            'prefill_room_id' => $request->get('room_id'),
            'prefill_date' => $request->get('date'),
            'prefill_start' => $request->get('start'),
            'prefill_end' => $request->get('end'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'author_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $room = MeetingRoom::findOrFail($data['meeting_room_id']);

        MeetingBookingService::validate(
            $room,
            $data['date'],
            $data['start_time'],
            $data['end_time']
        );

        MeetingBooking::create($data);

        return redirect()
            ->route('meeting-rooms.show', $room)
            ->with('status', 'Встреча создана');
    }

    public function edit(MeetingBooking $meeting_booking)
    {
        $rooms = MeetingRoom::where('is_active', true)->orderBy('id')->get();

        return view('admin.meeting-bookings.edit', [
            'booking' => $meeting_booking,
            'rooms' => $rooms,
        ]);
    }

    public function update(Request $request, MeetingBooking $meeting_booking)
    {
        $data = $request->validate([
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'author_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $room = MeetingRoom::findOrFail($data['meeting_room_id']);

        MeetingBookingService::validate(
            $room,
            $data['date'],
            $data['start_time'],
            $data['end_time'],
            $meeting_booking->id
        );

        $meeting_booking->update($data);

        return redirect()
            ->route('meeting-rooms.show', $room)
            ->with('status', 'Встреча обновлена');
    }

    public function destroy(MeetingBooking $meeting_booking)
    {
        $roomId = $meeting_booking->meeting_room_id;
        $meeting_booking->delete();

        return redirect()
            ->route('meeting-rooms.show', $roomId)
            ->with('status', 'Встреча удалена');
    }
}
