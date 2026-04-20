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
        Schema::create('compatibilitylist', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->string('version');
            $table->string('type');
            $table->string('status');
            $table->string('os');
            $table->date('createdDate'); // TODO: Change to use timestamps(). Also required to change the column in the database
            $table->date('updatedDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilitylist');
    }
};
