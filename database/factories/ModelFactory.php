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
        'name' => $faker->name,
        'email' => $faker->email,
        'username' => $faker->unique()->userName,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Lista::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->text($maxNbChars = 200),
        'report_id' => 1,
    ];
});

$factory->define(App\Report::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 2,
        'type_id' => 1,
        'datetime' => $faker->dateTimeThisMonth(),
        // 'datetime' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});
