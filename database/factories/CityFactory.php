<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {

    return [
        'nameCity' => $faker->city,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'idCountry' => factory(Country::class)
    ];
});
