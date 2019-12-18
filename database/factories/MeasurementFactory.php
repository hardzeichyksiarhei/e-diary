<?php

use Faker\Generator as Faker;

$factory->define(App\Measurement::class, function (Faker $faker) {
    return [
        'length_body' => $faker->numberBetween($min = 150, $max = 210),
        'mass_body' => $faker->numberBetween($min = 30, $max = 120),
        'chss_lie' => $faker->numberBetween($min = 30, $max = 120),
        'chss_stand' => $faker->numberBetween($min = 30, $max = 120),
        'chss_initial' => $faker->numberBetween($min = 30, $max = 120),
        'chss_after_load' => $faker->numberBetween($min = 30, $max = 120),
        'chss_restoring' => $faker->numberBetween($min = 30, $max = 120),
        'sample_shtange' => $faker->numberBetween($min = 30, $max = 120),
        'sample_genchi' => $faker->numberBetween($min = 30, $max = 120),
        'long_jump' => $faker->numberBetween($min = 30, $max = 120),
        'torso_inclination' => $faker->numberBetween($min = 30, $max = 120),
        'shuttle' => $faker->numberBetween($min = 30, $max = 120),
        'pull_up' => $faker->numberBetween($min = 30, $max = 120),
        'frexion_extension_trunk' => $faker->numberBetween($min = 30, $max = 120),
        'push_up' => $faker->numberBetween($min = 30, $max = 120),
        'run_30' => $faker->numberBetween($min = 30, $max = 120),
        'run_1000' => $faker->numberBetween($min = 30, $max = 120),
        'run_1500' => $faker->numberBetween($min = 30, $max = 120),
        'run_3000' => $faker->numberBetween($min = 30, $max = 120),
        'swimming_25' => $faker->numberBetween($min = 30, $max = 120),
        'swimming_50' => $faker->numberBetween($min = 30, $max = 120)
    ];
});
