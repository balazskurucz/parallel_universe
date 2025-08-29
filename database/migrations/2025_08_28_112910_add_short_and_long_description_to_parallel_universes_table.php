<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
        });

        // Migrate existing description data to long_description
        DB::table('parallel_universes')->whereNotNull('description')->update([
            'long_description' => DB::raw('description'),
            'short_description' => DB::raw('SUBSTR(description, 1, 500)'),
        ]);

        // Remove the old description column
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the description column
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->text('description')->nullable();
        });

        // Migrate long_description back to description
        DB::table('parallel_universes')->whereNotNull('long_description')->update([
            'description' => DB::raw('long_description'),
        ]);

        // Remove the new columns
        Schema::table('parallel_universes', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'long_description']);
        });
    }
};
