<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingBooking extends Model
{
    protected $fillable = [
        'meeting_room_id',
        'date',
        'start_time',
        'end_time',
        'title',
        'author_name',
        'comment',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    public function room()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id');
    }
}
