<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_repair_cetakans', function (Blueprint $table) {
            if (!Schema::hasColumn('form_repair_cetakans', 'tindakan')) {
                $table->text('tindakan')->nullable()->after('problem');
            }
            if (!Schema::hasColumn('form_repair_cetakans', 'analisa')) {
                $table->text('analisa')->nullable()->after('tindakan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_repair_cetakans', function (Blueprint $table) {
            $table->dropColumn(['tindakan', 'analisa']);
        });
    }
};
