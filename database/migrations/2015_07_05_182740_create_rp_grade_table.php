<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpGrade', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rp_id')->unsigned();
            $table->integer('wrestler_id')->unsigned();
            $table->integer('fed_grade');
            $table->text('comment')->nullable();
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
        Schema::drop('rpGrade');
    }
}
