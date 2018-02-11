<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fname' => 'Jimmy',
            'mname' => 'Sky',
            'lname' => 'Parker',
            'dob' => '1990-09-23',
            'contact' => '418-4822',
            'email' => 'jimmy.lomocso@gmail.com',
            'center_id' => 0,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'level' => 'admin',
            'status' => 'registered'
        ]);
    }
}
