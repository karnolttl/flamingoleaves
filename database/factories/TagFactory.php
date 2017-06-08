<?php

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->jobTitle . ' ' . $faker->word,
    ];
});
