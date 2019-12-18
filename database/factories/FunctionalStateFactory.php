<?php

use Faker\Generator as Faker;

$factory->define(App\FunctionalState::class, function (Faker $faker) {
    return [
        'length_body' => $faker->numberBetween($min = 160, $max = 190),
        'mass_body' => $faker->numberBetween($min = 55, $max = 90),
        'chss_lie' => $faker->numberBetween($min = 50, $max = 55),
        'chss_stand' => $faker->numberBetween($min = 55, $max = 60),
        'chss_initial' => $faker->numberBetween($min = 10, $max = 15),
        'chss_after_load' => $faker->numberBetween($min = 15, $max = 25),
        'chss_restoring' => $faker->numberBetween($min = 15, $max = 20),
        'sample_shtange' => $faker->numberBetween($min = 50, $max = 90),
        'sample_genchi' => $faker->numberBetween($min = 25, $max = 45),
    ];
});
