<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Короткий ярлык / бейдж (например "Важно")
            if (!Schema::hasColumn('news', 'label')) {
                $table->string('label')->nullable()->after('title');
            }

            // Аудитория (для кого новость)
            if (!Schema::hasColumn('news', 'audience')) {
                $table->string('audience')->nullable()->after('label');
            }

            // Отдел / источник
            if (!Schema::hasColumn('news', 'department')) {
                $table->string('department')->nullable()->after('audience');
            }

            // Краткое описание
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('department');
            }

            // Тело новости — на всякий случай, если на сервере нет
            if (!Schema::hasColumn('news', 'content')) {
                $table->longText('content')->nullable()->after('excerpt');
            }

            // Дата публикации
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->dateTime('published_at')->nullable()->after('content');
            }

            // Автор новости
            if (!Schema::hasColumn('news', 'author_id')) {
                $table->unsignedBigInteger('author_id')->nullable()->after('published_at');
                $table->index('author_id', 'news_author_id_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'label')) {
                $table->dropColumn('label');
            }
            if (Schema::hasColumn('news', 'audience')) {
                $table->dropColumn('audience');
            }
            if (Schema::hasColumn('news', 'department')) {
                $table->dropColumn('department');
            }
            if (Schema::hasColumn('news', 'excerpt')) {
                $table->dropColumn('excerpt');
            }
            if (Schema::hasColumn('news', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('news', 'published_at')) {
                $table->dropColumn('published_at');
            }
            if (Schema::hasColumn('news', 'author_id')) {
                $table->dropIndex('news_author_id_index');
                $table->dropColumn('author_id');
            }
        });
    }
};
