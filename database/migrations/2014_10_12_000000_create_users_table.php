<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname',100);
            $table->string('mname',100);
            $table->string('lname',100);
            $table->string('suffix',10);
            $table->date('dob');
            $table->string('contact',20);
            $table->string('email');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->integer('province_id');
            $table->integer('region_id');
            $table->string('username');
            $table->string('password');
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
        Schema::drop('users');
    }
}
