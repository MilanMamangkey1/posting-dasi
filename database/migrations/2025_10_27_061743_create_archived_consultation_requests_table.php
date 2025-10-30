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
        Schema::create('archived_consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_request_id');
            $table->string('full_name');
            $table->string('address');
            $table->text('issue_description');
            $table->string('whatsapp_number');
            $table->enum('status', ['resolved'])->default('resolved');
            $table->text('admin_notes')->nullable();
            $table->timestamp('handled_at')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index('archived_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_consultation_requests');
    }
};
