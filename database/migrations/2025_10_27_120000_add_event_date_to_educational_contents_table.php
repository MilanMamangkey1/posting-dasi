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
        Schema::table('educational_contents', function (Blueprint $table): void {
            if (! Schema::hasColumn('educational_contents', 'event_date')) {
                $table->date('event_date')->nullable()->after('summary');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_contents', function (Blueprint $table): void {
            if (Schema::hasColumn('educational_contents', 'event_date')) {
                $table->dropColumn('event_date');
            }
        });
    }
};
