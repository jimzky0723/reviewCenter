<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instructor_id');
            $table->string('code');
            $table->text('desc');
            $table->integer('center_id');
            $table->date('date_open');
            $table->date('date_close');
            $table->string('time_out')->after('desc');
            $table->string('time_in')->after('desc');
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
        Schema::drop('classes');
    }
}
