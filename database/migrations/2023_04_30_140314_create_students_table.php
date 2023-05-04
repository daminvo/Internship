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
            $table->boolean('available')->default(true);
            $table->string('cv')->nullable();
            $table->string('speciality');
            $table->bigInteger('security_number')->nullable();
            $table->date('birthday');
            $table->string('birth_place');
            $table->unsignedBigInteger('departement_id')->index();
            $table->foreign('departement_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
