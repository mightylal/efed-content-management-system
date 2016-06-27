<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedPage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('content')->nullable();
            $table->string('access');
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
        Schema::drop('fedPage');
    }
}
