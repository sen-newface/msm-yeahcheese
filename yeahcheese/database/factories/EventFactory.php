<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $datetime = $faker->dateTimeThisYear;

    return [
        'title' => $faker->word,
        'release_date' => $datetime->format('Y-m-d H:i'),
        'end_date' => $datetime->modify('+7day')->format('Y-m-d H:i'),
        'user_id' => factory(App\User::class),
    ];
});
