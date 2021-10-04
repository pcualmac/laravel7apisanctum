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
        DB::table('users')->insert([
            'name' => 'jerry',
            'email' => 'pumpignano@gmail.com',
            'password' => Hash::make('testtest'),
        ]);
    }
}
