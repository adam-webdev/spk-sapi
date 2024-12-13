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
        Schema::create('matriks_3', function (Blueprint $table) {
            $table->id();
            $table->string('matriks_3_1', 6);
            $table->string('matriks_3_2', 6);
            $table->string('matriks_3_3', 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_3');
    }
};
