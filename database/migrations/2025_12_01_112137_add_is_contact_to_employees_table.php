<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Если колонка уже существует — просто выходим
        if (Schema::hasColumn('employees', 'is_contact')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            // Если нет full_name — добавляем без "after", чтобы не падало
            if (Schema::hasColumn('employees', 'full_name')) {
                $table->boolean('is_contact')
                    ->default(false)
                    ->after('full_name');
            } else {
                $table->boolean('is_contact')
                    ->default(false);
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('employees', 'is_contact')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('is_contact');
        });
    }
};
