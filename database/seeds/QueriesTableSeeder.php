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
        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 1,
            'result' => 1,
        ]);

        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 5,
            'result' => 2,
        ]);

        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 11,
            'result' => 3,
        ]);

        factory(Query::class, 3)->create();

        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 2,
            'result' => 1,
        ]);

        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 15,
            'result' => 2,
        ]);

        $queries_count = Query::count()+1;

        Query::create([
            'relatedQuery_id' => $queries_count,
            'area_id' => 9,
            'result' => 2,
        ]);

        factory(Query::class, 3)->create();
    }
}
