<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('news_posts')
            ->where(function ($q) {
                $q->where('published', false)->orWhereNull('published_at');
            })
            ->update([
                'published'    => true,
                'published_at' => DB::raw('COALESCE(published_at, NOW())'),
            ]);
    }

    public function down(): void
    {
        // Irreversible: we don't know which rows were originally unpublished.
    }
};
