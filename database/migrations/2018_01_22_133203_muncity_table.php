<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MuncityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muncity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',100);
            $table->string('desc',100);
            $table->string('regCode',100);
            $table->string('provCode',100);
            $table->string('muncityCode',100);
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
        Schema::drop('muncity');
    }
}
