<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Удаляем старое поле body, которое больше не используем
            if (Schema::hasColumn('news', 'body')) {
                $table->dropColumn('body');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // На откате просто вернём body как nullable
            if (!Schema::hasColumn('news', 'body')) {
                $table->longText('body')->nullable();
            }
        });
    }
};