<?php

namespace App\PhysicalFitness;

use App\Traits\CalculateAge;
use Illuminate\Support\Collection;

class TorsoInclination {
	use CalculateAge;

	const NAME = 'Наклон туловища вперед, см';

	// <= 6 and >= 25
	const DATA_WOMAN_17_18 = [
			2 => [ 7, 8 ],
			3 => [ 9, 10 ],
			4 => [ 11, 12 ],
			5 => [ 13, 14 ],
			6 => [ 15, 16 ],
			7 => [ 17, 18 ],
			8 => [ 19, 21 ],
			9 => [ 22, 24 ]
	];

	// <= 6 and >= 28
	const DATA_WOMAN_19_22 = [
			2 => [ 7, 10 ],
			3 => 11,
			4 => [ 12, 13 ],
			5 => [ 14, 15 ],
			6 => [ 16, 18 ],
			7 => 19,
			8 => [ 20, 23 ],
			9 => [ 24, 27 ]
	];

	// <= 1 and >= 21
	const DATA_MAN_17_18 = [
			2 => [ 2, 4 ],
			3 => [ 5, 7 ],
			4 => [ 8, 9 ],
			5 => [ 10, 12 ],
			6 => 13,
			7 => [ 14, 15 ],
			8 => [ 16, 18 ],
			9 => [ 19, 20 ]
	];

	// <= 3 and >= 30
	const DATA_MAN_19_22 = [
			2 => [ 4, 6 ],
			3 => [ 7, 8 ],
			4 => [ 9, 10 ],
			5 => [ 11, 12 ],
			6 => [ 13, 14 ],
			7 => [ 15, 16 ],
			8 => [ 17, 20 ],
			9 => [ 21, 29 ]
	];

	public static function getTorsoInclinationPoint ($gender, $birthday, $torso_inclination = 0) {

			$data = [];

			$firstValue = $lastValue = 0;

			$age = self::calculateAge($birthday);

			if ($gender == 'woman' && $age >= 17 && $age <= 18) {
					$data = TorsoInclination::DATA_WOMAN_17_18;
					$firstValue = 6;
					$lastValue = 25;
			}

			if ($gender == 'woman' && $age >= 19 && $age <= 22) {
					$data = TorsoInclination::DATA_WOMAN_19_22;
					$firstValue = 6;
					$lastValue = 28;
			}
			
			if ($gender == 'man' && $age >= 17 && $age <= 18) {
					$data = TorsoInclination::DATA_MAN_17_18;
					$firstValue = 1;
					$lastValue = 21;
			}
			
			if ($gender == 'man' && $age >= 19 && $age <= 22) {
					$data = TorsoInclination::DATA_MAN_19_22;
					$firstValue = 3;
					$lastValue = 30;
			}

			$point = 0;

			$flag = false;

			foreach ($data as $key=>$item) {
					if ( is_array($item) && $torso_inclination >= $item[0] && $torso_inclination <= $item[1] ) {
							$point = $key;
							$flag = true;
							break;
					}

					if ( !is_array($item) && $torso_inclination == $item ) {
							$point = $key;
							$flag = true;
							break;
					}
			}

			if ( !$flag && $torso_inclination <= $firstValue ) $point = 1;
			if ( !$flag && $torso_inclination >= $lastValue ) $point = 10;

			return $point;

	}
}