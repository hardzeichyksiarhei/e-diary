<?php

namespace App\FunctionalState;

use Illuminate\Support\Collection;

class DosedLoad {

    const NAME = 'Проба на дозированную нагрузку';

    const DATA_WOMAN = [
        2 => [ 15, 16 ],
        3 => [ 13, 14 ],
        4 => [ 11, 12 ],
        5 => [ 9, 10 ],
        6 => [ 7, 8 ],
        7 => [ 5, 6 ],
        8 => [ 3, 4 ],
        9 => [ 1, 2 ]
    ];

    const DATA_MAN = DosedLoad::DATA_WOMAN;

    public static function getDosedLoadPoint ($gender, $chss_initial = 0, $chss_after_load = 0, $chss_restoring = 0) {

        $dosedLoad = (6 * ( $chss_initial + $chss_after_load + $chss_restoring ) - 200 ) / 10;

        $data = [];

        if ($gender == 'woman') $data = DosedLoad::DATA_WOMAN;
        if ($gender == 'man') $data = DosedLoad::DATA_MAN;

        $point = 1; // 17 и более

        foreach ($data as $key=>$item) {
            if ( is_array($item) && $dosedLoad >= $item[0] && $dosedLoad <= $item[1] ) {
                $point = $key;
                break;
            }
        }

        if ( $dosedLoad <= 0 ) $point = 10; // 0 и менее

        return [ $dosedLoad, $point ];

    }
}