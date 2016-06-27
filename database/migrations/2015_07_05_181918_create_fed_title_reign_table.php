<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedTitleReignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedTitleReign', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('title_id')->unsigned();
            $table->timestamp('date_won');
            $table->integer('defenses')->default(0);
            $table->timestamp('date_lost')->nullable();
            $table->timestamp('last_defense')->nullable();
            $table->integer('wrestler_id_one')->default(0);
            $table->integer('wrestler_id_two')->default(0);
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
        Schema::drop('fedTitleReign');
    }
}
