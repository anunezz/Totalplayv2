<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_units', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_serie_id')->nullable();
            $table->unsignedBigInteger('cat_administrative_unit_id')->nullable();

            $table->foreign('cat_serie_id')
                ->references('id')
                ->on('cat_series');

            $table->foreign('cat_administrative_unit_id')
                ->references('id')
                ->on('cat_administrative_units');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_units');
    }
}
