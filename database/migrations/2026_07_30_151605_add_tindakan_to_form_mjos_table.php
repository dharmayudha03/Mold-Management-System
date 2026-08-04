<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_mjos', function (Blueprint $table) {
            if (!Schema::hasColumn('form_mjos', 'tindakan')) {
                $table->text('tindakan')->nullable()->after('penanganan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_mjos', function (Blueprint $table) {
            $table->dropColumn('tindakan');
        });
    }
};
