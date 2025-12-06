<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Если колонка уже есть — ничего не делаем
        if (Schema::hasColumn('employees', 'avatar_path')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            // Если в таблице есть phone_mobile — ставим после него
            if (Schema::hasColumn('employees', 'phone_mobile')) {
                $table->string('avatar_path')
                    ->nullable()
                    ->after('phone_mobile');
            }
            // Если phone_mobile нет, но есть email — ставим после email
            elseif (Schema::hasColumn('employees', 'email')) {
                $table->string('avatar_path')
                    ->nullable()
                    ->after('email');
            }
            // На всякий случай — просто добавляем колонку без after()
            else {
                $table->string('avatar_path')
                    ->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('employees', 'avatar_path')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('avatar_path');
        });
    }
};
