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
    Schema::create('meeting_rooms', function (Blueprint $table) {
        $table->id();

        $table->string('name'); // Переговорная 1 / 2
        $table->unsignedInteger('capacity')->nullable(); // опционально
        $table->time('work_start')->default('08:00:00');
        $table->time('work_end')->default('20:00:00');
        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_rooms');
    }
};
