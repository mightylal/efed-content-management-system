<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumViewTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forumViewTopic', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('topic_id')->unsigned();
            $table->integer('wrestler_id')->unsigned();
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
        Schema::drop('forumViewTopic');
    }
}
