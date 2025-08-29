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
        Schema::table('media', function (Blueprint $table) {
            // Drop the morphs index first if it exists
            if (Schema::hasColumn('media', 'mediable_type') && Schema::hasColumn('media', 'mediable_id')) {
                $table->dropMorphs('mediable');
            } else {
                // Drop individual columns if they exist
                if (Schema::hasColumn('media', 'mediable_type')) {
                    $table->dropColumn('mediable_type');
                }
                if (Schema::hasColumn('media', 'mediable_id')) {
                    $table->dropColumn('mediable_id');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('mediable_type')->nullable();
            $table->unsignedBigInteger('mediable_id')->nullable();
        });
    }
};
