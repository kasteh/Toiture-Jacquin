<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Departement;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Departement::class, function (Faker $faker) {
    $name = $faker->sentence();
    $code = $faker->numberBetween(10,99);
    return [
        'name'=>$name,
        'slug'=>Str::slug($name).'-'.$code,
        'code'=>$code
    ];
});
