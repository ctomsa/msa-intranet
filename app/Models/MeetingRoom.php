<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'work_start',
        'work_end',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'work_start' => 'string',
        'work_end' => 'string',
    ];

    public function bookings()
    {
        return $this->hasMany(MeetingBooking::class);
    }
}
