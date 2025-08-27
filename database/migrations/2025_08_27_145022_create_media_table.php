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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); // Original filename
            $table->string('file_path'); // Path to the stored file
            $table->string('file_type'); // image or video
            $table->string('mime_type'); // MIME type (image/jpeg, video/mp4, etc.)
            $table->unsignedBigInteger('file_size'); // File size in bytes
            $table->string('alt_text')->nullable(); // Alt text for accessibility
            $table->text('description')->nullable(); // Optional description
            $table->morphs('mediable'); // Creates mediable_type and mediable_id columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
