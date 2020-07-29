<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionSubseriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_subseries', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_description_id')->nullable();
            $table->unsignedBigInteger('cat_subserie_id')->nullable();

            $table->foreign('cat_description_id')
                ->references('id')
                ->on('cat_descriptions');

            $table->foreign('cat_subserie_id')
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
        Schema::dropIfExists('description_subseries');
    }
}
