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
            $table->integer('umur');
            $table->string('jenis_kelamin');
            $table->integer('berat');
            $table->string('kondisi_mulut_datar');
            $table->string('kepala');
            $table->string('leher_bergelambir');
            $table->string('punggung_datar');
            $table->string('ekor_tidak_ada_legokan');
            $table->string('kaki_tegak_besar');
            $table->string('kondisi_gigi_lengkap');
            $table->string('kondisi_mata_normal');
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
