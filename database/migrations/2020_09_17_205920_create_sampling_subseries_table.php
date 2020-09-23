<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplingSubseriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_subseries', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_sampling_id')->nullable();
            $table->unsignedBigInteger('cat_subserie_id')->nullable();

            $table->foreign('cat_sampling_id')
                ->references('id')
                ->on('cat_samplings');

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
        Schema::dropIfExists('sampling_subseries');
    }
}
