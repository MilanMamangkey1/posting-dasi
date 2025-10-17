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
        Schema::table('educational_contents', function (Blueprint $table) {
            $table->string('content_type')
                ->default('general')
                ->after('slug');
            $table->string('media_path')
                ->nullable()
                ->after('video_url');
            $table->json('meta')
                ->nullable()
                ->after('hero_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_contents', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'media_path', 'meta']);
        });
    }
};
