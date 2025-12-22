<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeetingRoom;
class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    MeetingRoom::query()->delete();

    MeetingRoom::create([
        'name' => 'Переговорная 1',
        'capacity' => null,
        'work_start' => '08:00',
        'work_end' => '20:00',
        'is_active' => true,
    ]);

    MeetingRoom::create([
        'name' => 'Переговорная 2',
        'capacity' => null,
        'work_start' => '08:00',
        'work_end' => '20:00',
        'is_active' => true,
    ]);
}
}
