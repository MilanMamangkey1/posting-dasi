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
        Schema::create('content_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('educational_content_id')
                ->constrained('educational_contents')
                ->cascadeOnDelete();
            $table->string('type');
            $table->string('storage_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('ordering')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['educational_content_id', 'ordering']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_assets');
    }
};
