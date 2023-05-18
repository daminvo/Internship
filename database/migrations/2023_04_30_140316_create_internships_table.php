<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//return new class extends Migration
class CreateInternshipsTable extends migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('duration');
            $table->longText('description')->nullable();
            $table->string('title');
            $table->boolean('state')->default(false);
            $table->date('demand_date');
            $table->unsignedBigInteger('manager_id')->index();
            $table->foreign('manager_id')->references('id')->on('internship_managers')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
