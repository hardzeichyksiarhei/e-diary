<?php

namespace App\FunctionalState;

use Illuminate\Support\Collection;

class SampleShtange {

    const NAME = 'Проба Штанге';

    const DATA_WOMAN = [
        2 => [ 20, 22 ],
        3 => [ 23, 25 ],
        4 => [ 26, 28 ],
        5 => [ 29, 31 ],
        6 => [ 32, 34 ],
        7 => [ 35, 37 ],
        8 => [ 38, 40 ],
        9 => [ 41, 43 ]
    ];

    const DATA_MAN = [
        2 => [ 29, 31 ],
        3 => [ 32, 34 ],
        4 => [ 35, 37 ],
        5 => [ 38, 40 ],
        6 => [ 41, 43 ],
        7 => [ 44, 46 ],
        8 => [ 47, 49 ],
        9 => [ 50, 52 ]
    ];

    public static function getSampleShtangePoint ($gender, $sample_shtange = 0) {

        $data = [];

        if ($gender == 'woman') $data = SampleShtange::DATA_WOMAN;
        if ($gender == 'man') $data = SampleShtange::DATA_MAN;

        $point = 0;

        foreach ($data as $key=>$item) {
            if ( $sample_shtange >= $item[0] && $sample_shtange <= $item[1] ) {
                $point = $key;
                break;
            }
        }

        if ( $gender == 'woman' && $sample_shtange <= 19 ) $point = 1; // 19 и менее
        if ( $gender == 'woman' && $sample_shtange >= 44 ) $point = 10; // 44 и более

        if ( $gender == 'man' && $sample_shtange <= 28 ) $point = 1; // 28 и менее
        if ( $gender == 'man' && $sample_shtange >= 53 ) $point = 10; // 53 и более

        return $point;

    }
}