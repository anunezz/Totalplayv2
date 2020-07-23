<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_section_id');
            $table->string('name');
            $table->string('code');
//            $table->unsignedBigInteger('cat_value_id');
//            $table->unsignedBigInteger('cat_documentary_id');
            $table->unsignedBigInteger('cat_selection_id');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_section_id')
                ->references('id')
                ->on('cat_sections');

//            $table->foreign('cat_value_id')
//                ->references('id')
//                ->on('cat_primary_values');
//
//            $table->foreign('cat_documentary_id')
//                ->references('id')
//                ->on('cat_documentary_validities');

            $table->foreign('cat_selection_id')
                ->references('id')
                ->on('cat_selection_techniques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_series');
    }
}