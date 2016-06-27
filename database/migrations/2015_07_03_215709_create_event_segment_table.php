<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSegmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventSegment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->integer('title_id')->unsigned();
            $table->string('type', 50);
            $table->string('name');
            $table->longText('result');
            $table->tinyInteger('publish')->default(0);
            $table->integer('placement');
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
        Schema::drop('eventSegment');
    }
}
