<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_descriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_unit_id')->nullable();
            $table->unsignedBigInteger('cat_series_id')->nullable();
            $table->longText('description');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_unit_id')
                ->references('id')
                ->on('cat_administrative_units');

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
        Schema::dropIfExists('cat_descriptions');
    }
}
