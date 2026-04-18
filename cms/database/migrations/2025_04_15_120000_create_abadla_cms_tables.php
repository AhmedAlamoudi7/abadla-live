<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('family_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedInteger('member_count')->default(0);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('location')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('body')->nullable();
            $table->string('detail_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_breaking')->default(false);
            $table->boolean('show_on_home')->default(false);
            $table->string('layout_role')->nullable();
            $table->string('mosaic_slot')->nullable();
            $table->boolean('is_hourly_featured')->default(false);
            $table->unsignedInteger('important_sort')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamps();
        });

        Schema::create('news_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('slot')->default(1);
            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('album_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('family_members')->nullOnDelete();
            $table->foreignId('family_branch_id')->nullable()->constrained('family_branches')->nullOnDelete();
            $table->string('full_name');
            $table->string('short_name')->nullable();
            $table->string('role')->nullable();
            $table->string('year_range')->nullable();
            $table->text('bio')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('icon_key')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('personalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_branch_id')->nullable()->constrained('family_branches')->nullOnDelete();
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->string('birth_gregorian')->nullable();
            $table->string('birth_hijri')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('album_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_category_id')->constrained('album_categories')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('social_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('social_occasions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_category_id')->constrained('social_categories')->cascadeOnDelete();
            $table->string('title');
            $table->date('occurred_on')->nullable();
            $table->string('image')->nullable();
            $table->text('excerpt')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('famous_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('line_one')->nullable();
            $table->text('line_two')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('archive_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('individual');
            $table->string('full_name');
            $table->string('phone_country', 8)->default('+970');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('collection_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('home_featured_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_featured_events');
        Schema::dropIfExists('collection_items');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('archive_submissions');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('famous_members');
        Schema::dropIfExists('social_occasions');
        Schema::dropIfExists('social_categories');
        Schema::dropIfExists('album_items');
        Schema::dropIfExists('personalities');
        Schema::dropIfExists('family_members');
        Schema::dropIfExists('album_categories');
        Schema::dropIfExists('news_banners');
        Schema::dropIfExists('news_posts');
        Schema::dropIfExists('events');
        Schema::dropIfExists('family_branches');
        Schema::dropIfExists('settings');
    }
};
