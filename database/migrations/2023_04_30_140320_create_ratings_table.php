<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateRatingsTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('work_ability');
            $table->bigInteger('discipline');
            $table->bigInteger('initiative');
            $table->bigInteger('capacity_imagination');
            $table->bigInteger('acquired_knowledge');
            $table->bigInteger('total_note');
            $table->string('appreciation');
            $table->unsignedBigInteger('intern_id')->index();
            $table->foreign('intern_id')->references('id')->on('interns')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
