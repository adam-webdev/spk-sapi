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
        Schema::create('dataset_sapis', function (Blueprint $table) {
            $table->id();
            $table->integer('x_sapi_id');
            $table->integer('x1');
            $table->integer('x2');
            $table->integer('x3');
            $table->integer('x4');
            $table->integer('x5');
            $table->integer('x6');
            $table->integer('x7');
            $table->integer('x8');
            $table->integer('x9');
            $table->integer('x10');
            $table->integer('x11');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_sapis');
    }
};
