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
            'name' => 'default2',
            'surname' => 'user',
            'email' => 'default2@user.com',
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

        User::create([
            'name' => 'doctor2',
            'surname' => 'user',
            'email' => 'doctor2@user.com',
            'doctor' => true,
            'phone' => '+34622333444',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'doctor3',
            'surname' => 'user',
            'email' => 'doctor3@user.com',
            'doctor' => true,
            'phone' => '+34622333444',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'doctor4',
            'surname' => 'user',
            'email' => 'doctor4@user.com',
            'doctor' => true,
            'phone' => '+34622333444',
            'password' => bcrypt('123456'),
        ]);

        factory(User::class, 30)->create();
    }
}
