<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
	$message = $faker->text($maxNbChars = 1000);
	return [
		'sender_id' => $faker->randomElement([1, 2, 3, 4]),
		'subject' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'excerpt' => str_limit($message, 120, '...'),
		'message' => '<p>' . $message . '</p>'
	];
});
