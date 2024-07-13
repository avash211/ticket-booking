<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_time_id');
            $table->string('seat_number');
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->string('email')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('show_time_id')->references('id')->on('show_times')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
