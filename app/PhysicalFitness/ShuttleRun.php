<?php

namespace App\PhysicalFitness;

use App\Traits\CalculateAge;
use Illuminate\Support\Collection;

class ShuttleRun {
	use CalculateAge;

    const NAME = 'Челночный бег 4 х 9 м, с';

    // >= 11.9 and <= 10.0
    const DATA_WOMAN_17_18 = [
        2 => [ 11.8, 11.6 ],
        3 => [ 11.5, 11.4 ],
        4 => [ 11.3, 11.2 ],
        5 => [ 11.1, 10.9 ],
        6 => 10.8,
        7 => [ 10.7, 10.6 ],
        8 => [ 10.5, 10.3 ],
        9 => [ 10.2, 10.1 ]
    ];

    // >= 12.7 and <= 10.0
    const DATA_WOMAN_19_22 = [
        2 => [ 12.6, 12.2 ],
        3 => [ 12.1, 12.0 ],
        4 => [ 11.9, 11.7 ],
        5 => [ 11.6, 11.3 ],
        6 => [ 11.2, 11.1 ],
        7 => [ 11.0, 10.9 ],
        8 => [ 10.8, 10.7 ],
        9 => [ 10.6, 10.1 ]
    ];

    // >= 10.7 and <= 8.6
    const DATA_MAN_17_18 = [
        2 => [ 10.6, 10.4 ],
        3 => [ 10.3, 10.1 ],
        4 => [ 10.0, 9.9 ],
        5 => [ 9.8, 9.7 ],
        6 => [ 9.6, 9.5 ],
        7 => [ 9.4, 9.3 ],
        8 => [ 9.2, 9.0 ],
        9 => [ 8.9, 8.7 ]
    ];

    // >= 10.9 and <= 8.9
    const DATA_MAN_19_22 = [
        2 => [ 10.8, 10.4 ],
        3 => [ 10.3, 10.1 ],
        4 => [ 10.0, 9.9 ],
        5 => [ 9.8, 9.7 ],
        6 => [ 9.6, 9.5 ],
        7 => 9.4,
        8 => [ 9.3, 9.2 ],
        9 => [ 9.1, 9.0 ]
    ];

    public static function getShuttleRunPoint ($gender, $birthday, $shuttle_run = 0) {

        $data = [];

				$firstValue = $lastValue = 0;
				
				$age = self::calculateAge($birthday);

        if ($gender == 'woman' && $age >= 17 && $age <= 18) {
            $data = ShuttleRun::DATA_WOMAN_17_18;
            $firstValue = 11.9;
            $lastValue = 10.0;
        }

        if ($gender == 'woman' && $age >= 19 && $age <= 22) {
            $data = ShuttleRun::DATA_WOMAN_19_22;
            $firstValue = 12.7;
            $lastValue = 10.0;
        }
        
        if ($gender == 'man' && $age >= 17 && $age <= 18) {
            $data = ShuttleRun::DATA_MAN_17_18;
            $firstValue = 10.7;
            $lastValue = 8.6;
        }
        
        if ($gender == 'man' && $age >= 19 && $age <= 22) {
            $data = ShuttleRun::DATA_MAN_19_22;
            $firstValue = 10.9;
            $lastValue = 8.9;
        }

        $point = 0;

        $flag = false;

        foreach ($data as $key=>$item) {
            if ( is_array($item) && $shuttle_run <= $item[0] && $shuttle_run >= $item[1] ) {
                $point = $key;
                $flag = true;
                break;
            }

            if ( !is_array($item) && $shuttle_run == $item ) {
                $point = $key;
                $flag = true;
                break;
            }
        }

        if ( !$flag && $shuttle_run >= $firstValue ) $point = 1;
        if ( !$flag && $shuttle_run <= $lastValue ) $point = 10;

        return $point;

    }
}