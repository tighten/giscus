<?php

use App\NotifiedComment;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\app\Gist;

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
        'token' => Str::random(40),
    ];
});

$factory->define(NotifiedComment::class, function (Faker\Generator $faker) {
    return [
        'github_id' => factory(User::class)->create()->github_id,
        'github_updated_at' => Carbon::now(),
    ];
});

$factory->define(Gist::class, function (Faker\Generator $faker) {
    return [
        'url' => $faker->url,
        'forks_url' => $faker->url,
        'commits_url' => $faker->url,
        'id' => str_random(30),
        'node_id' => str_random(30),
        'git_pull_url' => $faker->url,
        'git_push_url' => $faker->url,
        'html_url' => $faker->url,
        'files' => [],
        'public' => true,
        'created_at' => $faker->time('Y-m-d'),
        'updated_at' => $faker->time('Y-m-d'),
        'description' => $faker->word,
        'comments' => 0,
        'user' => null,
        'comments_url' => $faker->url,
        'owner' => [],
        'forks' => [],
        'history' => [],
        'truncated' => false,
    ];
});
