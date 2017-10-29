<?php

use App\NotifiedComment;
use App\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'github_id' => $faker->randomNumber(7),
        'name' => $faker->name,
        'email' => $faker->email,
        'avatar' => $faker->imageUrl,
        'token' => str_random(40),
    ];
});

$factory->define(NotifiedComment::class, function (Faker\Generator $faker) {
    return [
        'github_id' => factory(User::class)->create()->github_id,
        'github_updated_at' => Carbon::now(),
    ];
});
