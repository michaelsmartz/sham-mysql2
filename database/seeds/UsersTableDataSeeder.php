<?php

use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'Username' => 'demo user',
            'email' => 'demouser@smartz.com',
            'password' => bcrypt('demouser'),
            'sham_user_profile_id' => 4
        ]);
    }
}