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
        Schema::create('consultation_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_request_id')
                ->constrained('consultation_requests')
                ->cascadeOnDelete();
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('status_after_update');
            $table->text('message')->nullable();
            $table->timestamp('follow_up_at')->nullable();
            $table->timestamps();

            $table->index('consultation_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_updates');
    }
};
