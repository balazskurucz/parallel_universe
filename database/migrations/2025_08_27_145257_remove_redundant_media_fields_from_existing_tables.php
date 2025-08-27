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
        // Remove cover_image_path from parallel_universes table
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->dropColumn('cover_image_path');
        });

        // Remove image_path and video_url from historical_events table
        Schema::table('historical_events', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'video_url']);
        });

        // Remove image_path and video_url from news_broadcasts table
        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'video_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore cover_image_path to parallel_universes table
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->string('cover_image_path')->nullable();
        });

        // Restore image_path and video_url to historical_events table
        Schema::table('historical_events', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
        });

        // Restore image_path and video_url to news_broadcasts table
        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
        });
    }
};
