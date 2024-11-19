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
        Schema::create('sapi_testings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_sapi');
            $table->double('umur');
            $table->string('jenis_kelamin')->nullable();
            $table->double('berat');
            $table->integer('kondisi_mulut_datar');
            $table->integer('kepala')->nullable();
            $table->integer('leher_bergelambir')->nullable();
            $table->integer('punggung_datar');
            $table->integer('ekor_tidak_ada_legokan')->nullable();
            $table->integer('kaki_tegak_besar')->nullable();
            $table->integer('kondisi_gigi_lengkap');
            $table->integer('kondisi_mata_normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sapi_testings');
    }
};