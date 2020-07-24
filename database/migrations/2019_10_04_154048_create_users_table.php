<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('office');
            $table->unsignedBigInteger('cat_profile_id');
            $table->unsignedBigInteger('cat_consulate_id')->nullable();
            $table->string('name');
            $table->string('firstName');
            $table->string('secondName')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_profile_id')
                ->references('id')
                ->on('cat_profiles');

            $table->foreign('cat_consulate_id')
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
        Schema::dropIfExists('users');
    }
}
