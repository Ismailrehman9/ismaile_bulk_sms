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
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                'name' => "Ovais Tariq",
                'email' => "admin@gmail.com",
                'password' => Hash::make('asdasdasd'),
            ]);
        } else {
            echo "User Table is not empty, NOT Seeding";
        }
    }
}
