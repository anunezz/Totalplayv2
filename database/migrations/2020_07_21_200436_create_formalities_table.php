<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('type_report')->nullable();
            $table->unsignedBigInteger('type_selection')->nullable();
            $table->unsignedBigInteger('email_notify')->default(0);
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('serie_id');
            $table->unsignedBigInteger('subserie_id')->nullable();
            $table->string('opening_date');
            $table->string('close_date');
            $table->unsignedBigInteger('consecutive');
            $table->unsignedBigInteger('legajo');
            $table->string('sort_code')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('description_id')->nullable();
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('format_id');
            $table->unsignedBigInteger('documentary_tradition_id');
            $table->unsignedBigInteger('legajos');
            $table->unsignedBigInteger('initial_folio');
            $table->unsignedBigInteger('end_folio');
            $table->unsignedBigInteger('total_fojas')->nullable();
            $table->boolean('question_one');
            $table->boolean('question_two')->nullable();
            $table->boolean('haveQuality')->nullable();
            $table->unsignedBigInteger('transparency_resolution_id')->nullable();
            $table->unsignedBigInteger('nature_information_id')->nullable();
            $table->unsignedBigInteger('classification_reason_id')->nullable();
            $table->string('classification_date')->nullable();
            $table->string('name_titular')->nullable();
            $table->string('transparency_proceedings')->nullable();
            $table->string('restricted_parts')->nullable();
            $table->string('legal_basis')->nullable();
            $table->unsignedBigInteger('reservation_period')->nullable();
            $table->unsignedBigInteger('deadline_extension')->nullable();
            $table->string('Record_official_number')->nullable();
            $table->string('declassification_date')->nullable();
            $table->text('name_public_server')->nullable();
            $table->text('position_public_server')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornalities');
    }
}
