<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateInternshipOffersTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('internship_offres', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('nmbr_postions');
            $table->boolean('public')->default(true);
            $table->unsignedBigInteger('internship_id')->index();
            $table->foreign('internship_id')->references('id')->on('internships')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_offres');
    }
};
