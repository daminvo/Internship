<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateScoresTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->time('entry_time');
            $table->time('exit_time');
            $table->string('observation')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('intern_id')->index();
            $table->foreign('intern_id')->references('id')->on('interns');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
