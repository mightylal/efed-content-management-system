<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWrestlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wrestler', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('slug');
            $table->integer('age');
            $table->string('gender');
            $table->string('height');
            $table->integer('weight');
            $table->longText('bio');
            $table->tinyInteger('activated')->default(0);
            $table->tinyInteger('admin')->default(0);
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::drop('wrestler');
    }
}
