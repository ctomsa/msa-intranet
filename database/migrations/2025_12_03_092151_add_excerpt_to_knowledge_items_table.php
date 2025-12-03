<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            // Краткое описание, можно строку или текст, как удобнее
            $table->string('excerpt', 500)
                ->nullable()
                ->after('category'); // или after('title') — не критично
        });
    }

    public function down(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            $table->dropColumn('excerpt');
        });
    }
};