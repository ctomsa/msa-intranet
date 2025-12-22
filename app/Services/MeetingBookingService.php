<?php

namespace App\Services;

use App\Models\MeetingBooking;
use App\Models\MeetingRoom;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class MeetingBookingService
{
    public static function validate(
        MeetingRoom $room,
        string $date,
        string $startTime,
        string $endTime,
        ?int $ignoreBookingId = null
    ): void {
        $start = Carbon::parse($date.' '.$startTime);
        $end   = Carbon::parse($date.' '.$endTime);

        if ($end <= $start) {
            throw ValidationException::withMessages([
                'time' => 'Время окончания должно быть позже времени начала',
            ]);
        }

        // минимум 15 минут
        if ($start->diffInMinutes($end) < 15) {
            throw ValidationException::withMessages([
                'time' => 'Минимальная длительность встречи — 15 минут',
            ]);
        }

        // рабочее время переговорки
        $workStart = Carbon::parse($date.' '.$room->work_start);
        $workEnd   = Carbon::parse($date.' '.$room->work_end);

        if ($start < $workStart || $end > $workEnd) {
            throw ValidationException::withMessages([
                'time' => 'Встреча должна быть в пределах рабочего времени переговорки',
            ]);
        }

        // пересечения
        $conflictQuery = MeetingBooking::query()
            ->where('meeting_room_id', $room->id)
            ->where('date', $date)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<', $startTime)
                         ->where('end_time', '>', $endTime);
                  });
            });

        if ($ignoreBookingId) {
            $conflictQuery->where('id', '!=', $ignoreBookingId);
        }

        if ($conflictQuery->exists()) {
            throw ValidationException::withMessages([
                'time' => 'В это время переговорка уже занята',
            ]);
        }
    }
}
