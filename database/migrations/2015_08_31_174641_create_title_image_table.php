<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitleImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titleImage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('title_id')->unsigned();
            $table->string('mime');
            $table->string('extension');
            $table->string('type', 100);
            $table->string('url');
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
        Schema::drop('titleImage');
    }
}
