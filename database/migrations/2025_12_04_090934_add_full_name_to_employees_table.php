<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Если колонки full_name ещё нет — добавляем
        if (! Schema::hasColumn('employees', 'full_name')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('full_name')
                    ->nullable()
                    ->after('id'); // если хочешь — можешь поменять позицию
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('employees', 'full_name')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('full_name');
            });
        }
    }
};
