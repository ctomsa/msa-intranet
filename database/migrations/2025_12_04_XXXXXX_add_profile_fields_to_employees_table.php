<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Должность
            if (!Schema::hasColumn('employees', 'position')) {
                $table->string('position')->nullable()->after('full_name');
            }

            // Отдел
            if (!Schema::hasColumn('employees', 'department')) {
                $table->string('department')->nullable()->after('position');
            }

            // E-mail
            if (!Schema::hasColumn('employees', 'email')) {
                $table->string('email')->nullable()->after('department');
            }

            // Мобильный телефон
            if (!Schema::hasColumn('employees', 'phone_mobile')) {
                $table->string('phone_mobile', 50)->nullable()->after('email');
            }

            // Обязанности
            if (!Schema::hasColumn('employees', 'responsibilities')) {
                $table->text('responsibilities')->nullable()->after('phone_mobile');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'position')) {
                $table->dropColumn('position');
            }

            if (Schema::hasColumn('employees', 'department')) {
                $table->dropColumn('department');
            }

            if (Schema::hasColumn('employees', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('employees', 'phone_mobile')) {
                $table->dropColumn('phone_mobile');
            }

            if (Schema::hasColumn('employees', 'responsibilities')) {
                $table->dropColumn('responsibilities');
            }
        });
    }
};
