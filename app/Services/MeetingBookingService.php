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
	// пересечения (разрешаем "стык": конец = начало)
$conflictQuery = MeetingBooking::query()
    ->where('meeting_room_id', $room->id)
    ->where('date', $date)
    ->where('start_time', '<', $endTime)   // существующая начинается раньше конца новой
    ->where('end_time', '>', $startTime);  // существующая заканчивается позже начала новой

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
