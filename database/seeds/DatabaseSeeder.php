<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->truncateTables([
            'users',
            'admins',
            'queries',
            'areas',
        ]);

        $this->call(UserSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(QueriesTableSeeder::class);
    }

    public function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
