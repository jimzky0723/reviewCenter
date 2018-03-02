<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('target');
            $table->integer('user_id');
            $table->integer('center_id');
            $table->integer('subject_id');
            $table->text('content');
            $table->date('date_created');
            $table->integer('created_by')->after('date_created');
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
        Schema::drop('announcement');
    }
}
