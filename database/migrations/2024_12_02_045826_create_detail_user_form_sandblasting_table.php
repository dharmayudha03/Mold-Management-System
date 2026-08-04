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
        Schema::create('detail_user_form_sandblasting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_sandblasting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('detail_user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_user_form_sandblasting');
    }
};
