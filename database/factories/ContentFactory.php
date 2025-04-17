<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Content;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Content::class, function (Faker $faker) {
    $title = $faker->sentence();
    return [
        'category_id'=> Category::all()->random()->id,
        'title'=>$title,
        'slug'=>Str::slug($title),
        'text'=>$faker->paragraph(),
        'image'=>'toiture.jpg'
    ];
});
