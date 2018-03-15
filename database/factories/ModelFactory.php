<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->firstName,
        'email' => $faker->unique()->email,
        'password' => app('hash')->make('12345'),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(),
        'body' => $faker->paragraph(20, true),
        'user_id' => rand(1, 10),
        'category_id' => rand(1, 6),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'author' => $faker->userName(),
        'content' => $faker->sentence(),
        'post_id' => rand(1, 20),
        'parent_id' => 0,
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'alias' => $faker->word(),
        // 'name' => $faker->words(rand(1, 3), true),
        'name' => $faker->colorName,
    ];
});