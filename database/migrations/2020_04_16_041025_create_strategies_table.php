<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrategiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strategies', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('period')->nullable();
            $table->unsignedBigInteger('cat_consulate_id')->nullable();
            $table->string('date')->nullable();
            $table->string('guns')->nullable();
            $table->string('civilSociety')->nullable();
            $table->string('democrats')->nullable();
            $table->string('republicans')->nullable();
            $table->string('academy')->nullable();
            $table->string('economicActors')->nullable();
            $table->string('personalities')->nullable();
            $table->string('localAuthorities')->nullable();
            $table->string('media')->nullable();
            $table->string('articleLink')->nullable();
            $table->string('additional')->nullable();
            $table->string('observations')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strategies');
    }
}
