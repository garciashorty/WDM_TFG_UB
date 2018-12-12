<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'default',
            'surname' => 'user',
            'email' => 'default@user.com',
            'doctor' => false,
            'phone' => '+34611222333',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'doctor',
            'surname' => 'user',
            'email' => 'doctor@user.com',
            'doctor' => true,
            'phone' => '+34622333444',
            'password' => bcrypt('123456'),
        ]);
    }
}
