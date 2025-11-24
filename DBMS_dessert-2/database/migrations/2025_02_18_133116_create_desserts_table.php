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
        Schema::create('desserts', function (Blueprint $table) {
            $table->id('DessertID');
            $table->string('Dessert_name');
            $table->float('price');
            $table->string('Description')->nullable()->change();
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desserts');
        $table->string('Description')->nullable(false)->change();
        $table->string('image')->nullable();
    }
};
