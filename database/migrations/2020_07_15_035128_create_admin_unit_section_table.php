<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUnitSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_unit_section', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_administrative_unit_id')->nullable();
            $table->unsignedBigInteger('cat_section_id')->nullable();

            $table->foreign('cat_administrative_unit_id')
                ->references('id')
                ->on('cat_administrative_units');

            $table->foreign('cat_section_id')
                ->references('id')
                ->on('cat_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_unit_section');
    }
}
