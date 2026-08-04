<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_setup_cetakans', function (Blueprint $table) {
            if (!Schema::hasColumn('form_setup_cetakans', 'form_schedule_id')) {
                $table->foreignId('form_schedule_id')->nullable()->constrained('form_schedules')->nullOnDelete();
            }
        });

        Schema::table('form_sandblastings', function (Blueprint $table) {
            if (!Schema::hasColumn('form_sandblastings', 'form_schedule_id')) {
                $table->foreignId('form_schedule_id')->nullable()->constrained('form_schedules')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_setup_cetakans', function (Blueprint $table) {
            $table->dropForeign(['form_schedule_id']);
            $table->dropColumn('form_schedule_id');
        });

        Schema::table('form_sandblastings', function (Blueprint $table) {
            $table->dropForeign(['form_schedule_id']);
            $table->dropColumn('form_schedule_id');
        });
    }
};
