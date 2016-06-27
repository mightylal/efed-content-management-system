<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedStyle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('primary1')->nullable();
            $table->string('primary2')->nullable();
            $table->string('secondary1')->nullable();
            $table->string('secondary2')->nullable();
            $table->string('secondary3')->nullable();
            $table->string('secondary4')->nullable();
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
        Schema::drop('fedStyle');
    }
}
