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
        Schema::create('order__desserts', function (Blueprint $table) {
            $table->foreignId('DessertID')->constrained('Desserts', 'DessertID');
            $table->foreignId('OrderID')->constrained('Orders', 'OrderID');
            $table->unsignedInteger('Amount');
            $table->float('Total_Price');
            $table->primary(['DessertID', 'OrderID']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__desserts');
    }
};
