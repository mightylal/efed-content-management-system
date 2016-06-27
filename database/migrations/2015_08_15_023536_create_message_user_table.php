<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messageWrestler', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->integer('wrestler_id')->unsigned();
            $table->timestamp('viewed_at')->nullable();
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
        Schema::drop('messageWrestler');
    }
}
