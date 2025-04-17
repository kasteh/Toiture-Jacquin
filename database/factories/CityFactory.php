<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Departement;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(City::class, function (Faker $faker) {
    $name = $faker->sentence();
    $code = $faker->numberBetween(10,99);
    return [
        'departement_id'=> Departement::all()->random()->id,
        'name'=>$name,
        'slug'=>Str::slug($name).'-'.$code,
        'code'=>$code
    ];
});
