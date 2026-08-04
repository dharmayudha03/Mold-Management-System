<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('form_schedules', 'nodoc')) {
                $table->string('nodoc')->nullable();
            }
            if (!Schema::hasColumn('form_schedules', 'tanggal')) {
                $table->date('tanggal')->nullable();
            }
            if (!Schema::hasColumn('form_schedules', 'detail_user_id')) {
                $table->foreignId('detail_user_id')->nullable()->constrained('detail_users')->nullOnDelete();
            }
            if (!Schema::hasColumn('form_schedules', 'set_code_item_id')) {
                $table->foreignId('set_code_item_id')->nullable()->constrained('set_code_items')->nullOnDelete();
            }
            if (!Schema::hasColumn('form_schedules', 'cav_code_item_id')) {
                $table->foreignId('cav_code_item_id')->nullable()->constrained('cav_code_items')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_schedules', function (Blueprint $table) {
            $table->dropColumn(['nodoc', 'tanggal', 'detail_user_id', 'set_code_item_id', 'cav_code_item_id']);
        });
    }
};
