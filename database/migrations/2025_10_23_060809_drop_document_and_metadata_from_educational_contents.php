<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('educational_contents', 'type')) {
            DB::statement("ALTER TABLE educational_contents MODIFY COLUMN type ENUM('video','image','document','narrative','material','photo') NOT NULL");

            DB::table('educational_contents')
                ->where('type', 'document')
                ->update([
                    'type' => 'material',
                    'file_path' => null,
                    'file_size_bytes' => null,
                ]);

            DB::table('educational_contents')
                ->where('type', 'image')
                ->update(['type' => 'photo']);

            DB::statement("ALTER TABLE educational_contents MODIFY COLUMN type ENUM('video','photo','narrative','material') NOT NULL");
        }

        Schema::table('educational_contents', function (Blueprint $table) {
            if (Schema::hasColumn('educational_contents', 'metadata')) {
                $table->dropColumn('metadata');
            }

            if (Schema::hasColumn('educational_contents', 'published_at')) {
                $table->dropColumn('published_at');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('educational_contents', 'type')) {
            DB::statement("ALTER TABLE educational_contents MODIFY COLUMN type ENUM('video','photo','narrative','material','image','document') NOT NULL");

            DB::table('educational_contents')
                ->where('type', 'photo')
                ->update(['type' => 'image']);

            DB::statement("ALTER TABLE educational_contents MODIFY COLUMN type ENUM('video','image','document','narrative','material') NOT NULL");
        }

        Schema::table('educational_contents', function (Blueprint $table) {
            if (! Schema::hasColumn('educational_contents', 'metadata')) {
                $table->json('metadata')->nullable()->after('file_size_bytes');
            }

            if (! Schema::hasColumn('educational_contents', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('metadata');
            }
        });
    }
};
