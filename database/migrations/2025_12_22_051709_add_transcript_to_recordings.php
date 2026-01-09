<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('recordings', 'transcript')) {
            Schema::table('recordings', function (Blueprint $table) {
                $table->longText('transcript')->nullable()->after('file_path');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('recordings', 'transcript')) {
            Schema::table('recordings', function (Blueprint $table) {
                $table->dropColumn('transcript');
            });
        }
    }
};
