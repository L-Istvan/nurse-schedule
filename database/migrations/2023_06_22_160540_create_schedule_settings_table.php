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
        Schema::create('schedule_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('n');
            $table->boolean('e');
            $table->boolean('nn');
            $table->boolean('ee');
            $table->boolean('ne');
            $table->boolean('en');
            $table->boolean('nne');
            $table->boolean('nee');
            $table->boolean('nnn');
            $table->boolean('eee');
            $table->boolean('enn');
            $table->boolean('een');
            $table->boolean('nen');
            $table->boolean('ene');
            $table->boolean('folytonos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_settings');
    }
};
