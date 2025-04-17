<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Agence;
use Faker\Generator as Faker;

$factory->define(Agence::class, function (Faker $faker) {
    return [
        'agence_name'=>$faker->name(),
        'agence_adress'=>$faker->address(),
        'agence_owner_name'=>$faker->name(),
        'agence_owner_email'=>$faker->email(),
        'agence_owner_phone'=>$faker->phoneNumber(),
        'lat'=>$faker->latitude(41,50),
        'lng'=>$faker->longitude(-3,8)
    ];
});
