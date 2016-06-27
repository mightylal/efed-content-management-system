<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description');
            $table->string('access');
            $table->string('posting');
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
        Schema::drop('forum');
    }
}
