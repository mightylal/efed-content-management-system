<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forumPost', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->integer('wrestler_id')->unsigned();
            $table->text('post');
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
        Schema::drop('forumPost');
    }
}
