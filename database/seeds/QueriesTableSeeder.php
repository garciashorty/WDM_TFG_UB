<?php

use Illuminate\Database\Seeder;
use App\Query;
use App\User;

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
            'user_id' => 1,
            'relatedQuery_id' => 1,
            'area_id' => 3,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 1,
            'relatedQuery_id' => 2,
            'area_id' => 9,
            'result' => 2,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 1,
            'relatedQuery_id' => 1,
            'area_id' => 3,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 1,
            'relatedQuery_id' => 1,
            'area_id' => 3,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);


        Query::create([
            'user_id' => 7,
            'relatedQuery_id' => 5,
            'area_id' => 12,
            'result' => 2,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 2,
            'relatedQuery_id' => 6,
            'area_id' => 18,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 2,
            'relatedQuery_id' => 6,
            'area_id' => 18,
            'result' => 2,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 2,
            'relatedQuery_id' => 8,
            'area_id' => 10,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 15,
            'relatedQuery_id' => 9,
            'area_id' => 8,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 15,
            'relatedQuery_id' => 9,
            'area_id' => 10,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 23,
            'relatedQuery_id' => 11,
            'area_id' => 5,
            'result' => 3,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 23,
            'relatedQuery_id' => 11,
            'area_id' => 5,
            'result' => 3,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 23,
            'relatedQuery_id' => 13,
            'area_id' => 3,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 23,
            'relatedQuery_id' => 14,
            'area_id' => 14,
            'result' => 2,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 20,
            'relatedQuery_id' => 15,
            'area_id' => 7,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);

        Query::create([
            'user_id' => 20,
            'relatedQuery_id' => 16,
            'area_id' => 18,
            'result' => 1,
            'image' => 'queries/images/default.png',
        ]);
    }
}
