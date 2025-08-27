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
        Schema::create('news_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parallel_universe_id')->constrained()->onDelete('cascade');
            $table->string('headline');
            $table->date('broadcast_date');
            $table->text('short_description');
            $table->longText('long_description');
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_broadcasts');
    }
};
