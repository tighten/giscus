<?php

use Carbon\Carbon;

if (! function_exists('arrayfactory')) {
    function arrayfactory($name)
    {
        $faker = app(Faker\Generator::class);

        switch ($name) :
            case 'gist':
                return [
                    'html_url' => $faker->url,
                    'description' => $faker->paragraph,
                ];

            case 'comment':
                return [
                    'id' => $faker->randomDigit,
                    'updated_at' => Carbon::now()->subDays(3)->format('Y-m-d\TH:i:s\Z'),
                    'body' => $faker->paragraph,
                    'user' => [
                        'avatar_url' => $faker->url,
                        'html_url' => $faker->url,
                        'login' => $faker->userName,
                    ]
                ];
        endswitch;

        throw new Exception("Array factory $name not found.");
    }
}
