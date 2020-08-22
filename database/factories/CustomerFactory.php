<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use Faker\Generator as Faker;


$factory->define(Customer::class, function (Faker $faker) {
    return [
        'firstName' => $faker->name(10),
        'lastName' => $faker->name(10),
        'password' => $faker->password(6,20),
        'idCountry' => $faker->Country::select('idCountry')->random(5),
        'idCity' =>$faker->City::select('idCity')->random(5),
        'email' => $faker->email,
        'addressCustomer' => $faker->address,
        'phoneCustomer' => $faker->phoneNumber
    ];
});
