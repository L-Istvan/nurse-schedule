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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('person_id');
            $table->integer('maxYearHoliday');
            $table->integer('currentYearHoliday');
            $table->integer('maxMonthHoliday');
            $table->integer('currentMonthHoliday');
            $table->integer('maxPetitons');
            $table->integer('currentPetitons');
            $table->integer('sickLeaves');
            $table->integer('numberOfDays');
            $table->integer('numberOfNights');
            $table->integer('maxNumberOfWorkersInOnday');
            $table->integer('minNumberOfWorkersInOnday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
