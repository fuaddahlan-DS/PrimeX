<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName',100);
            $table->string('icNumber',15);
            $table->string('contactPerson',100);
            $table->string('mobileNumber',15);
            $table->string('houseNumber',15);
            $table->string('email',100);
            $table->text('address');
            $table->string('filmTitle',100);
            $table->string('filmFileFormat',10);
            $table->string('youtubeLink');
            $table->string('filmLanguage',50);
            $table->string('filmDuration',25);
            $table->text('filmSynopsis');
            $table->text('filmFunFact');
            $table->string('filmPosterPath');
            $table->string('filmDirector',100);
            $table->string('filmProducer',100);
            $table->string('filmScreenPlayWritter',100);
            $table->string('filmScriptWritter',100);
            $table->string('filmCinematographer',100);
            $table->string('filmProductionDesigner',100);
            $table->string('filmSoundDesigner',100);   
            $table->string('filmEditor',100);
            $table->string('filmMainCasts');
            $table->string('filmCasts');
            $table->text('filmOthers');
            $table->string('status',20)->default('submitted');
            $table->integer('votes')->nullable()->default(0);
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
        Schema::dropIfExists('contests');
    }
}
