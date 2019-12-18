<?php

use Faker\Generator as Faker;

$factory->define(App\ProfileStaff::class, function (Faker $faker) {
    return [
			'birthday' => $faker->dateTimeBetween($startDate = '-23 years', $endDate = '-18 years', $timezone = 'UTC')->format('d/m/Y'),
			'position' => $faker->word,
			'rank' => $faker->word,
			'degree' => $faker->word,
			'description' => $faker->text($maxNbChars = 400)
    ];
});
