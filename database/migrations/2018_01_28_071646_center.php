<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Center extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',100);
            $table->string('desc',100);
            $table->integer('limit');
            $table->integer('regCode');
            $table->integer('provCode');
            $table->integer('muncityCode');
            $table->integer('barangayCode');
            $table->string('contact',100);
            $table->integer('user_id');
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
        Schema::drop('center');
    }
}
