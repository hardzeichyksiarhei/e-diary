<?php

use Faker\Generator as Faker;

$factory->define(App\PhysicalFitness::class, function (Faker $faker) {
    return [
	    'long_jump' => $faker->numberBetween($min = 190, $max = 250),
	    'torso_inclination' => $faker->numberBetween($min = -20, $max = 20),
	    'run_shuttle' => $faker->randomFloat($nbMaxDecimals = 1, $min = 9, $max = 15),
	    'pull_up' => $faker->numberBetween($min = 0, $max = 15),
        'press' => $faker->numberBetween($min = 30, $max = 120),
        'push_up' => $faker->numberBetween($min = 0, $max = 50),
	    'run_short' => $faker->randomFloat($nbMaxDecimals = 1, $min = 4, $max = 5),
	    'run_long' => $faker->numberBetween($min = 0, $max = 600),
        'swimming_s' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 0.40),
        'swimming_m' => 0,
    ];
});
