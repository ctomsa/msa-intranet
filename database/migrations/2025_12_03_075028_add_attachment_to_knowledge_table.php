<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            // добавляем колонку, не указывая after(...)
            if (!Schema::hasColumn('knowledge_items', 'attachment_path')) {
                $table->string('attachment_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            if (Schema::hasColumn('knowledge_items', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
        });
    }
};