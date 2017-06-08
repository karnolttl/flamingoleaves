<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {

    return [
        'post_title' => $faker->cityPrefix . ' ' . $faker->streetName,
        'owner_id' => rand(1, DB::table('users')->count()),
        'slug' => $faker->slug,
        'category_id' => rand(1, DB::table('categories')->count()),
    ];
});
