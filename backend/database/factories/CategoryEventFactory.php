<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CategoryEvent;
use Faker\Generator as Faker;

$factory->define(CategoryEvent::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
