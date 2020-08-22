<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'countryName' => $faker->country,
        'codeNameCountry' => $faker->countryISOAlpha3,
        'countryCode' => $faker->countryCode,
    ];
});
