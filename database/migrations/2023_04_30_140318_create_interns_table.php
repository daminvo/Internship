<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateInternsTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->boolean('student_validation')->nullable();
            $table->boolean('manager_validation')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('motivation')->nullable();
            $table->unsignedBigInteger('internship_id')->index();
            $table->foreign('internship_id')->references('id')->on('internships')->onDelete('cascade');
            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
