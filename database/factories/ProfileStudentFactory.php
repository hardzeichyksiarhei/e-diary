<?php

use Faker\Generator as Faker;

$factory->define(App\ProfileStudent::class, function (Faker $faker) {

    $teacher_ids = App\User::where('role', 'teacher')->pluck('id')->toArray();
    $faculty_ids = App\Faculty::all('id')->pluck('id')->toArray();
    $health_group_ids = App\HealthGroup::all('id')->pluck('id')->toArray();

    return [ 
        'faculty_id' => $faker->randomElement($faculty_ids),
        'teacher_id' => $faker->randomElement($teacher_ids),  
        'health_group_id' => $faker->randomElement($health_group_ids), 
        'birthday' => $faker->dateTimeBetween($startDate = '-23 years', $endDate = '-18 years', $timezone = 'UTC')->format('d/m/Y'),
        'gender' => $faker->randomElement(['man', 'woman']), 
        'course' => $faker->numberBetween($min = 1, $max = 3), 
        'group' => $faker->numberBetween($min = 101, $max = 502),
        'disease' => $faker->text($maxNbChars = 300),
    ];
});
