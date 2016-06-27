<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedEvent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('scheduled_at');
            $table->text('preview');
            $table->date('deadline_at');
            $table->tinyInteger('run')->default(0);
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
        Schema::drop('fedEvent');
    }
}
