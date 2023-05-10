<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('offer_id')->index();
            $table->unique(['student_id', 'offer_id']);
            $table->boolean('status')->default(true);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('internship_offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
