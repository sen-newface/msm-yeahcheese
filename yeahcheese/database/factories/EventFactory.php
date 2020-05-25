<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'release_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i'),
        'end_date' => $faker->dateTimeBetween($faker->dateTimeBetween('now', '+7 days'), '+1 years')->format('Y-m-d H:i'),
        'auth_key' => hash('fnv132', $faker->name),
        'user_id' => factory(App\User::class),
    ];
});
