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
        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->dropColumn('en');
            $table->dropColumn('enn');
            $table->dropColumn('een');
            $table->dropColumn('nen');
            $table->dropColumn('ene');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->integer('en')->after('group_id');
            $table->integer('enn')->after('en');
            $table->integer('een')->after('enn');
            $table->integer('nen')->after('een');
            $table->integer('ene')->after('nen');
        });
    }
};
