<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSamplingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_samplings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_series_id')->nullable();
            $table->unsignedBigInteger('cat_subseries_id')->nullable();
            $table->longText('quality');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_series_id')
                ->references('id')
                ->on('cat_series');

            $table->foreign('cat_subseries_id')
                ->references('id')
                ->on('cat_subseries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_samplings');
    }
}
