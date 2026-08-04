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
        Schema::create('code_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('set_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('cav_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('partname')->nullable();
            $table->string('partnumber')->nullable();
            $table->string('customer')->nullable();
            $table->string('moldposisi')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_items');
    }
};
