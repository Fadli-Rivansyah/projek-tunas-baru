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
        Schema::create('ayams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_ayam_hidup');
            $table->integer('jumlah_ayam_mati');
            $table->integer('jumlah_pakan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayams');
    }
};
