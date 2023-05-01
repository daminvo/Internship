<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateStudentsTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->bigInteger('student_card');
            $table->boolean('state');
            $table->string('cv');
            $table->string('spiciality');
            $table->bigInteger('security_number')->nullable();
            $table->date('birthday');
            $table->string('birth_place');
            $table->unsignedBigInteger('departement_id')->index();
            $table->foreign('departement_id')->references('id')->on('departments');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
