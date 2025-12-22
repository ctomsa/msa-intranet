<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('meeting_bookings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('meeting_room_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');

        $table->string('title')->nullable(); // название встречи
        $table->string('author_name'); // ОБЯЗАТЕЛЬНО — кто инициировал
        $table->text('comment')->nullable();

        $table->timestamps();

        // защита от пересечений одинаковых слотов
        $table->index(['meeting_room_id', 'date']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_bookings');
    }
};
