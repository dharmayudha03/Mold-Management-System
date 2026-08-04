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
        Schema::create('class_mesins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('name_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_mesins');
    }
};
