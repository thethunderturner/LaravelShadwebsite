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
        Schema::create('compatibilitydb', function (Blueprint $table) {
            $table->id();
            $table->string('codedb');
            $table->string('titledb');
            $table->tinyInteger('parentalLevel');
            $table->string('contentId');
            $table->string('category');
            $table->boolean('psVr');
            $table->boolean('neoEnable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilitydb');
    }
};
