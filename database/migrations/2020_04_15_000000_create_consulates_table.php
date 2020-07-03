<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsulatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consulate_id');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('consulate_id')
            ->references('id')
            ->on('cat_consulates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulates');
    }
}
