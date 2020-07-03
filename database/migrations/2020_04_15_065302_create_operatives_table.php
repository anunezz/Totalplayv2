<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('consulatee_id')->unsigned()->nullable();;

            $table->longText('short_arms_description')->nullable();
            $table->integer('short_arms');

            $table->longText('long_weapons_description')->nullable();
            $table->integer('long_weapons');

            $table->longText('barret_description')->nullable();
            $table->integer('barret');

            $table->longText('description_chargers')->nullable();
            $table->integer('chargers');

            $table->longText('explosives_description')->nullable();
            $table->integer('explosives');

            $table->longText('rocket_launcher_description')->nullable();
            $table->integer('rocket_launcher');

            $table->longText('parts_accessories_description')->nullable();
            $table->integer('parts_accessories');

            $table->integer('mexicans')->nullable();
            $table->integer('americans')->nullable();
            $table->integer('others')->nullable();
            $table->longText('type_of_operative')->nullable();
            $table->string('link')->nullable();
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->string('localidad')->nullable();
            $table->string('longitud')->nullable();
            $table->string('latitud')->nullable();
            $table->timestamps();

            // $table->foreign('consulatee_id')
            // ->references('id')
            // ->on('consulates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operatives');
    }
}
