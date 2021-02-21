<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_promotions', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->default(1);
            $table->boolean('frontier')->default(0);
            $table->boolean('triple_double')->default(0);
            $table->string('name',100);
            $table->string('url',100);
            $table->string('color',100);
            $table->longText('description');
            $table->boolean('isActive')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_promotions');
    }
}
