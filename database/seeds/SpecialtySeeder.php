<?php

use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialty')->insert(['specialty' => 'Math']);
        DB::table('specialty')->insert(['specialty' => 'English']);
        DB::table('specialty')->insert(['specialty' => 'Science']);
        DB::table('specialty')->insert(['specialty' => 'Music']);
        DB::table('specialty')->insert(['specialty' => 'Technology/Computer']);
        DB::table('specialty')->insert(['specialty' => 'Programming']);
    }
}
