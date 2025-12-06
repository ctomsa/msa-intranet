<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Если колонка content уже есть — ничего не делаем
        if (Schema::hasColumn('news', 'content')) {
            return;
        }

        Schema::table('news', function (Blueprint $table) {
            // Если есть excerpt — ставим контент после него
            if (Schema::hasColumn('news', 'excerpt')) {
                $table->longText('content')
                    ->nullable()
                    ->after('excerpt');
            }
            // Если excerpt нет, но есть title — ставим после title
            elseif (Schema::hasColumn('news', 'title')) {
                $table->longText('content')
                    ->nullable()
                    ->after('title');
            }
            // На крайний случай — просто добавляем без after()
            else {
                $table->longText('content')
                    ->nullable();
            }
        });
    }

    public function down(): void
    {
        // Если content нет — откатывать нечего
        if (!Schema::hasColumn('news', 'content')) {
            return;
        }

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
};
