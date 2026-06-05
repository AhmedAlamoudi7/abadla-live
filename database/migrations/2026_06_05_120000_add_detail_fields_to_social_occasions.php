<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_occasions', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->json('images')->nullable()->after('image');
            $table->longText('body')->nullable()->after('excerpt');
        });

        // Backfill Arabic-friendly, unique slugs for existing rows.
        $used = [];
        DB::table('social_occasions')->orderBy('id')->get(['id', 'title', 'slug'])->each(function ($row) use (&$used) {
            if (! empty($row->slug)) {
                $used[$row->slug] = true;

                return;
            }

            $base = Str::slug((string) $row->title, '-', null);
            if ($base === '') {
                $base = 'occasion-'.$row->id;
            }

            $slug = $base;
            $i = 2;
            while (isset($used[$slug]) || DB::table('social_occasions')->where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }

            $used[$slug] = true;
            DB::table('social_occasions')->where('id', $row->id)->update(['slug' => $slug]);
        });

        Schema::table('social_occasions', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('social_occasions', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'images', 'body']);
        });
    }
};
