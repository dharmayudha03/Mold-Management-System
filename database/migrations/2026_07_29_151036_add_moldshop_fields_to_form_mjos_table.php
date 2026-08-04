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
        Schema::table('form_mjos', function (Blueprint $table) {
            $table->text('tindakan_moldshop')->nullable();
            $table->string('gambar_selesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('form_mjos', function (Blueprint $table) {
            $table->dropColumn(['tindakan_moldshop', 'gambar_selesai']);
        });
    }
};
