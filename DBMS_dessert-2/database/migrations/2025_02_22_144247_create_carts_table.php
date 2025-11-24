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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dessert_id');
            $table->foreign('dessert_id')->references('DessertID')->on('desserts')->onDelete('cascade');
            $table->unsignedBigInteger('festival_id');
            $table->foreign('festival_id')->references('FestivalID')->on('festivals')->onDelete('cascade');
            $table->string('session_id');
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
