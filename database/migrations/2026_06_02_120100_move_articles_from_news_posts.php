<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Move existing article-type posts out of news_posts and into their own
     * articles table. Articles are now managed separately from news.
     */
    public function up(): void
    {
        if (! Schema::hasTable('news_posts') || ! Schema::hasColumn('news_posts', 'type')) {
            return;
        }

        DB::transaction(function () {
            DB::statement(<<<'SQL'
                INSERT INTO articles
                    (title, slug, excerpt, body, featured_image, published_at, category, tags, published, created_at, updated_at)
                SELECT
                    title, slug, excerpt, body, featured_image, published_at, category, tags, published, created_at, updated_at
                FROM news_posts
                WHERE type = 'article'
            SQL);

            DB::table('news_posts')->where('type', 'article')->delete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('articles') || ! Schema::hasTable('news_posts')) {
            return;
        }

        DB::transaction(function () {
            DB::statement(<<<'SQL'
                INSERT INTO news_posts
                    (title, slug, excerpt, body, featured_image, published_at, category, type, tags, published, created_at, updated_at)
                SELECT
                    title, slug, excerpt, body, featured_image, published_at, category, 'article', tags, published, created_at, updated_at
                FROM articles
            SQL);

            DB::table('articles')->delete();
        });
    }
};
