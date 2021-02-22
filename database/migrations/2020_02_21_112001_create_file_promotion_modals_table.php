<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePromotionModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_promotion_modals', function (Blueprint $table) {
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
        Schema::dropIfExists('file_promotion_modals');
    }
}
