<?php

namespace App\FunctionalState;

use Illuminate\Support\Collection;

class MassIndex {

    const NAME = 'Росто-масовый показатель';

    const DATA_WOMAN = [
        2 => -16,
        2 => +9,
        3 => -14,
        3 => +8,
        4 => -14,
        4 => +7,
        5 => -13,
        5 => +6,
        6 => -12,
        6 => +5,
        7 => -11,
        7 => [ +3, +4 ],
        8 => [ -10, -9 ],
        8 => [ +1, +2 ],
        9 => [ -8, -6 ],
        10 => [ -5, 0 ]
    ];

    const DATA_MAN = MassIndex::DATA_WOMAN;

    private static function getCoefficient ($length) {

        if ($length <= 155) return 95;
        elseif ($length >= 156 && $length <= 165) return 100;
        elseif ($length >= 166 && $length <= 175) return 105;
        else return 110;

    }

    public static function getMassIndexPoint ($gender, $mass = 0, $length = 0) {

        $point = 1; // -17 и менее +10 и более

        $coefficient = MassIndex::getCoefficient($length);

        $massIndex = $mass - ($length - $coefficient);

        $data = [];

        if ($gender == 'woman') $data = MassIndex::DATA_WOMAN;
        if ($gender == 'man') $data = MassIndex::DATA_MAN;

        foreach ($data as $key=>$item) {
            if ( !is_array($item) && $massIndex == $item ) {
                $point = $key;
                break;
            }
            if ( is_array($item) && $massIndex >= $item[0] && $massIndex <= $item[1] ) {
                $point = $key;
                break;
            }
        }

        return [ $massIndex, $point ];

    }
}