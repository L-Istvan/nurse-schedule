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
        Schema::create('unique_links', function (Blueprint $table) {
            $table->id();
            $table->string('link')->unique();
            $table->tinyInteger('value')->default(0);
            $table->integer('group_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('education',['Segédápoló','Gyakorló ápoló','Szakápoló','Diplomás ápoló (bsc)','Diplomás ápoló (msc)']);
            $table->string('rank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unique_links');
    }
};
