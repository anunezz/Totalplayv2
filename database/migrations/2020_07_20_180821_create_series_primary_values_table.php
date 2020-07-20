<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesPrimaryValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_primary_values', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_serie_id')->nullable();
            $table->unsignedBigInteger('cat_primary_value_id')->nullable();

            $table->foreign('cat_serie_id')
                ->references('id')
                ->on('cat_series');

            $table->foreign('cat_primary_value_id')
                ->references('id')
                ->on('cat_primary_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_primary_values');
    }
}
