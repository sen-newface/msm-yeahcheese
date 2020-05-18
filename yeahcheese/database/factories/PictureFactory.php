<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Picture;
use Faker\Generator as Faker;

$factory->define(Picture::class, function (Faker $faker) {
    return [
        'path' => $faker->word,
        'event_id' => factory(App\Event::class),
    ];
});
