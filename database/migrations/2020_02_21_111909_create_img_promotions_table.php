<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_promotions', function (Blueprint $table) {

            //$table->bigIncrements('id');
            $table->id();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->text('fileName');
            $table->text('fileNameHash');
            $table->boolean('isActive')->default(0);
            $table->timestamps();

            $table->foreign('promotion_id')
                ->references('id')
                ->on('cat_promotions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_promotions');
    }
}
