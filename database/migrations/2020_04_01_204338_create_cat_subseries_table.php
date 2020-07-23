<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSubseriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_subseries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_series_id');
            $table->string('name');
            $table->string('code');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_series_id')
                ->references('id')
                ->on('cat_series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_subseries');
    }
}
