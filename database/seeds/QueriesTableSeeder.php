<?php

use Illuminate\Database\Seeder;
use App\Query;

class QueriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Query::create([
            'area_id' => 1,
            'result' => 1,
        ]);

        Query::create([
            'area_id' => 5,
            'result' => 2,
        ]);

        Query::create([
            'area_id' => 11,
            'result' => 3,
        ]);

        factory(Query::class, 3)->create();

        Query::create([
            'area_id' => 2,
            'result' => 1,
        ]);

        Query::create([
            'area_id' => 15,
            'result' => 2,
        ]);

        Query::create([
            'area_id' => 9,
            'result' => 2,
        ]);

        factory(Query::class, 3)->create();
    }
}
