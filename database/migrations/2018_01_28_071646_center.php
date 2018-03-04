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
            $table->string('desc',100);
            $table->integer('user_id');
            $table->string('owner');
            $table->string('path');
            $table->string('lat');
            $table->string('long');
            $table->integer('limit');
            $table->integer('no_month');
            $table->date('date_subscribed');
            $table->date('date_expired');
            $table->string('status');
            $table->integer('regCode');
            $table->integer('provCode');
            $table->integer('muncityCode');
            $table->integer('barangayCode');
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
