<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    $first_name = $faker->firstName;
    $last_name = $faker->lastName;

    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'name' => $first_name . ' ' . $last_name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'role' => $faker->randomElement(['teacher', 'student']),
        'has_profile' => true
    ];
});
