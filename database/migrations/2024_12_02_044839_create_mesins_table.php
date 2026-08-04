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
        Schema::create('mesins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('name_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('class_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('posisi');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesins');
    }
};
