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
        Schema::create('parallel_universes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Viking Vinland"
            $table->string('divergence_point'); // e.g., "Vikings successfully colonize North America in 1000 AD"
            $table->text('description'); // A summary of this universe
            $table->string('cover_image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parallel_universes');
    }
};
