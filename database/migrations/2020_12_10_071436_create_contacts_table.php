<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name',100);
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('promotion_id')->nullable();
            //$table->integer('zip_code');
            //$table->string('email',100)->nullable();
            $table->decimal('phone', 10,0);
            $table->string('promotion_code',100)->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cat_cities')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('cat_promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
