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
        Schema::create('hasilfcm', function (Blueprint $table) {
            $table->id();
            $table->integer('hasil_iterasi');
            $table->double('hasil_error_terkecil');
            $table->integer('hasil_jumlah_cluster');
            $table->longText('hasil_hitung_cluster');
            $table->longText('hasil_L');
            $table->longText('hasil_LT');
            $table->longText('hasil_cluster');
            $table->longText('fungsi_objektif');
            $table->longText('error');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilfcm');
    }
};