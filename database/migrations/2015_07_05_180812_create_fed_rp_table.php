<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedRpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedRp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wrestler_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->decimal('fed_score', 4, 2);
            $table->longText('rp');
            $table->string('name');
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
        Schema::drop('fedRp');
    }
}
