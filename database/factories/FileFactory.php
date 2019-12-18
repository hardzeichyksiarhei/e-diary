<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
  return [
		'name' => $faker->uuid,
		'type' => $faker->randomElement(['document', 'iamge']),
		'extension' => $faker->fileExtension
	];
});
