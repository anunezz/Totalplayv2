<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsOfAttentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_of_attentions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('attention_id')->nullable();
            $table->string('observations_contacted',100)->nullable();
            $table->string('observations_finish',100)->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('attention_id')->references('id')->on('cat_attentions');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels_of_attentions');
    }
}
