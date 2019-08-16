<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('users')->insert([
        	'name'=>str_random(10),
        	'email'=>str_random(10).'@laravelancademy.org',
        	'password'=>bcrypt('secert'),
        ])
    }
}
