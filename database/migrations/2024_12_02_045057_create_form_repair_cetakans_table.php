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
        Schema::create('form_repair_cetakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('set_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('cav_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('detail_user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('problem');
            $table->date('tanggal');
            $table->string('nodoc')->nullable();
            $table->string('gambar');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_repair_cetakans');
    }
};
