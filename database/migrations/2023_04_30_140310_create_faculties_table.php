<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateFacultiesTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('university_id')->index();
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
