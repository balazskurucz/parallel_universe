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
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('historical_events', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        Schema::table('historical_events', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        Schema::table('news_broadcasts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });
    }
};
