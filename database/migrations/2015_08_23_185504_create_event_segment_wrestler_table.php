<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSegmentWrestlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventSegmentWrestler', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('segment_id')->unsigned();
            $table->integer('wrestler_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->tinyInteger('winner')->default(0);
            $table->tinyInteger('loser')->default(0);
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
        Schema::drop('eventSegmentWrestler');
    }
}
