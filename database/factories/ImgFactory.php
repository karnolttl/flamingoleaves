<?php

$factory->define(App\Img::class, function (Faker\Generator $faker) {

    return [
        'name' => "pattern" . rand(1,19) . ".png",
        'owner_id' => 1,
        'post_id' => 1,
    ];
});
