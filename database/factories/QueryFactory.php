<?php

use Faker\Generator as Faker;



$factory->define(App\Query::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, App\User::count()),
        'area_id' => $faker->numberBetween(1, App\Area::count()),
        'relatedQuery_id' => $faker->numberBetween(1, App\Query::count()),
        'result' => $faker->numberBetween(1,3),
        'image' => 'queries/images/default.png',
        'idCounht' => 16,
    ];
});
