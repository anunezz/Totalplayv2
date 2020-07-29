<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_units', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_description_id')->nullable();
            $table->unsignedBigInteger('cat_unit_id')->nullable();

            $table->foreign('cat_description_id')
                ->references('id')
                ->on('cat_descriptions');

            $table->foreign('cat_unit_id')
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
        Schema::dropIfExists('description_units');
    }
}
