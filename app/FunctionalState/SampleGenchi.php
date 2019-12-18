<?php

namespace App\FunctionalState;

use Illuminate\Support\Collection;

class SampleGenchi {

    const NAME = 'Проба Генчи';

    const DATA_WOMAN = [
        2 => [ 15, 16 ],
        3 => [ 17, 18 ],
        4 => [ 19, 20 ],
        5 => [ 21, 22 ],
        6 => [ 23, 24 ],
        7 => [ 25, 26 ],
        8 => [ 27, 28 ],
        9 => [ 29, 30 ]
    ];

    const DATA_MAN = [
        2 => [ 19, 21 ],
        3 => [ 22, 24 ],
        4 => [ 25, 27 ],
        5 => [ 28, 30 ],
        6 => [ 31, 33 ],
        7 => [ 34, 36 ],
        8 => [ 37, 39 ],
        9 => [ 40, 42 ]
    ];

    public static function getSampleGenchiPoint ($gender, $sample_genchi = 0) {

        $data = [];

        if ($gender == 'woman') $data = SampleGenchi::DATA_WOMAN;
        if ($gender == 'man') $data = SampleGenchi::DATA_MAN;

        $point = 0;

        foreach ($data as $key=>$item) {
            if ( $sample_genchi >= $item[0] && $sample_genchi <= $item[1] ) {
                $point = $key;
                break;
            }
        }

        if ( $gender == 'woman' && $sample_genchi <= 14 ) $point = 1; // 14 и менее
        if ( $gender == 'woman' && $sample_genchi >= 31 ) $point = 10; // 31 и более

        if ( $gender == 'man' && $sample_genchi <= 18 ) $point = 1; // 18 и менее
        if ( $gender == 'man' && $sample_genchi >=43 ) $point = 10; // 43 и более

        return $point;

    }
}