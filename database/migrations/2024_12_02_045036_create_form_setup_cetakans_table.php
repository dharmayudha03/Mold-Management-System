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
        Schema::create('form_setup_cetakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('list_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('set_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('cav_code_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('list_mesin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('rak')->nullable();
            $table->string('norak')->nullable();
            $table->string('nodoc');
            $table->date('tanggal');
            $table->string('shift');
            $table->integer('cav_ng');
            $table->enum('guidepen', ['√', '-']);
            $table->enum('busing', ['√', '-']);
            $table->enum('baut', ['√', '-']);
            $table->enum('core', ['√', '-']);
            $table->enum('piston', ['√', '-']);
            $table->enum('pot', ['√', '-']);
            $table->enum('pl', ['√', '-']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_setup_cetakans', function (Blueprint $table) {
            $table->dropColumn('detail_user_id');
        });
    }
};
