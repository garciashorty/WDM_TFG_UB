<?php

use Faker\Generator as Faker;



$factory->define(App\Query::class, function (Faker $faker) {
    return [
        'area_id' => $faker->numberBetween(1, App\Area::count()),
        'relatedQuery_id' => $faker->numberBetween(1, App\Query::count()),
        'result' => $faker->numberBetween(1,3),
    ];
});
