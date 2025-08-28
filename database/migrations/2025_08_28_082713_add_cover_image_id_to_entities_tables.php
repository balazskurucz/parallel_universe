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
        // Add cover_image_id to parallel_universes table
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->foreign('cover_image_id')->references('id')->on('media')->onDelete('set null');
        });

        // Add cover_image_id to historical_events table
        Schema::table('historical_events', function (Blueprint $table) {
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->foreign('cover_image_id')->references('id')->on('media')->onDelete('set null');
        });

        // Add cover_image_id to news_broadcasts table
        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->foreign('cover_image_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove cover_image_id from parallel_universes table
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->dropForeign(['cover_image_id']);
            $table->dropColumn('cover_image_id');
        });

        // Remove cover_image_id from historical_events table
        Schema::table('historical_events', function (Blueprint $table) {
            $table->dropForeign(['cover_image_id']);
            $table->dropColumn('cover_image_id');
        });

        // Remove cover_image_id from news_broadcasts table
        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->dropForeign(['cover_image_id']);
            $table->dropColumn('cover_image_id');
        });
    }
};
