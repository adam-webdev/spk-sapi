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
        Schema::create('sapis', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_sapi');
            $table->integer('umur');
            $table->string('jenis_kelamin');
            $table->integer('berat');
            $table->integer('kondisi_mulut_datar');
            $table->integer('kepala');
            $table->integer('leher_bergelambir');
            $table->integer('punggung_datar');
            $table->integer('ekor_tidak_ada_legokan');
            $table->integer('kaki_tegak_besar');
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
        Schema::dropIfExists('sapis');
    }
};
