<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            $table->string('author_name')->nullable()->after('content');
            $table->string('author_position')->nullable()->after('author_name');
        });
    }

    public function down(): void
    {
        Schema::table('knowledge_items', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'author_position']);
        });
    }
};