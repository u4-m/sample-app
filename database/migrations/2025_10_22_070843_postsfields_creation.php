<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add columns that don't exist yet
            if (!Schema::hasColumn('posts', 'title')) {
                $table->string('title');
            }
            if (!Schema::hasColumn('posts', 'slug')) {
                $table->string('slug')->unique();
            } else {
                // Make sure slug is unique if it exists
                $table->string('slug')->unique()->change();
            }
            if (!Schema::hasColumn('posts', 'content')) {
                $table->text('content');
            }
            if (!Schema::hasColumn('posts', 'excerpt')) {
                $table->text('excerpt')->nullable();
            }
            if (!Schema::hasColumn('posts', 'featured_image')) {
                $table->string('featured_image')->nullable();
            }
            if (!Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
            if (!Schema::hasColumn('posts', 'is_published')) {
                $table->boolean('is_published')->default(false);
            }
            if (!Schema::hasColumn('posts', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            if (!Schema::hasColumn('posts', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
