<?php

namespace App\Traits;

trait CalculateAge {

	public static function calculateAge($birthday) {
		$birthday = str_replace('/', '-', $birthday);
		$birthday_timestamp = strtotime($birthday);
		$age = date('Y') - date('Y', $birthday_timestamp);
		if (date('md', $birthday_timestamp) > date('md')) {
			$age--;
		}
		return $age;
	}	

}