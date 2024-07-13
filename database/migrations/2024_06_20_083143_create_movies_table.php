<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('age_rating')->nullable();
            $table->integer('runtime')->nullable();
            $table->integer('year')->nullable();
            $table->string('language')->nullable();
            $table->string('genres')->nullable();
            $table->string('director')->nullable();
            $table->text('cast')->nullable();
            $table->string('slug')->unique();
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
