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
        Schema::create('matriks_4', function (Blueprint $table) {
            $table->id();
            $table->string('matriks_4_1', 6);
            $table->string('matriks_4_2', 6);
            $table->string('matriks_4_3', 6);
            $table->string('matriks_4_4', 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_4');
    }
};
