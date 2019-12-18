<?php

namespace App\PhysicalFitness;

use App\Traits\CalculateAge;
use Illuminate\Support\Collection;

class LongJump {

	use CalculateAge;

    const NAME = 'Прыжок в длину с места';

    // <= 154 and >= 202
    const DATA_WOMAN_17_18 = [
        2 => [ 155, 164 ],
        3 => [ 165, 169 ],
        4 => [ 170, 174 ],
        5 => [ 175, 179 ],
        6 => [ 178, 179 ],
        7 => [ 180, 189 ],
        8 => [ 190, 195 ],
        9 => [ 196, 201 ]
    ];

    // <= 149 and >= 205
    const DATA_WOMAN_19_22 = [
        2 => [ 150, 159 ],
        3 => [ 160, 164 ],
        4 => [ 165, 169 ],
        5 => [ 170, 173 ],
        6 => [ 174, 179 ],
        7 => [ 180, 183 ],
        8 => [ 184, 189 ],
        9 => [ 190, 204 ]
    ];

    // <= 204 and >= 265
    const DATA_MAN_17_18 = [
        2 => [ 205, 209 ],
        3 => [ 210, 219 ],
        4 => [ 220, 224 ],
        5 => [ 225, 229 ],
        6 => [ 230, 234 ],
        7 => [ 235, 239 ],
        8 => [ 240, 249 ],
        9 => [ 250, 264 ]
    ];

    // <= 204 and >= 265
    const DATA_MAN_19_22 = [
        2 => [ 205, 217 ],
        3 => [ 218, 221 ],
        4 => [ 222, 229 ],
        5 => [ 230, 232 ],
        6 => [ 233, 239 ],
        7 => [ 240, 244 ],
        8 => [ 245, 254 ],
        9 => [ 255, 264 ]
    ];

    public static function getLongJumpPoint ($gender, $birthday, $long_jump = 0) {

        $data = [];

				$firstValue = $lastValue = 0;
				
				$age = self::calculateAge($birthday);

        if ($gender == 'woman' && $age >= 17 && $age <= 18) {
            $data = LongJump::DATA_WOMAN_17_18;
            $firstValue = 154;
            $lastValue = 202;
        }

        if ($gender == 'woman' && $age >= 19 && $age <= 22) {
            $data = LongJump::DATA_WOMAN_19_22;
            $firstValue = 149;
            $lastValue = 205;
        }
        
        if ($gender == 'man' && $age >= 17 && $age <= 18) {
            $data = LongJump::DATA_MAN_17_18;
            $firstValue = 204;
            $lastValue = 265;
        }
        
        if ($gender == 'man' && $age >= 19 && $age <= 22) {
            $data = LongJump::DATA_MAN_19_22;
            $firstValue = 204;
            $lastValue = 265;
        }

        $point = 0;

        $flag = false;

        foreach ($data as $key=>$item) {
            if ( $long_jump >= $item[0] && $long_jump <= $item[1] ) {
                $point = $key;
                $flag = true;
                break;
            }
        }

        if ( !$flag && $long_jump <= $firstValue ) $point = 1;
        if ( !$flag && $long_jump >= $lastValue ) $point = 10;

        return $point;

    }
}