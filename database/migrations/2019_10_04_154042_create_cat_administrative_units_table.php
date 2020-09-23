<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatAdministrativeUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_administrative_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('cat_type_id')->nullable();
            $table->string('specialName')->nullable();
            $table->string('determinant')->nullable();
            $table->unsignedBigInteger('cat_responsible_id')->nullable();
            $table->unsignedBigInteger('cat_user_id')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_type_id')
                ->references('id')
                ->on('cat_type_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_administrative_units');
    }
}
