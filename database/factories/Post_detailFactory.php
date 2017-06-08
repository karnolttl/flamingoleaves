<?php

$factory->define(App\Post_detail::class, function (Faker\Generator $faker) {

    return [
        'post_id' => 1,
        'post_text' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
