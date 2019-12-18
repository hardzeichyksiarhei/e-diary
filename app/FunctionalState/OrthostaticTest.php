<?php

namespace App\FunctionalState;

use Illuminate\Support\Collection;

class OrthostaticTest {

    const NAME = 'Ортостатическая проба';

    const DATA_WOMAN = [
        2 => [ +24, +25 ],
        2 => [ -1, -3 ],
        3 => [ +22, +23 ],
        4 => [ +20, +21 ],
        5 => [ +17, +19 ],
        6 => [ +14, +16 ],
        7 => [ +11, +13 ],
        8 => [ +8, +10 ],
        9 => [ +4, +7 ],
        10 => [ 0, +3 ]
    ];

    const DATA_MAN = OrthostaticTest::DATA_WOMAN;

    public static function getOrthostaticTestData ($gender, $chss_lie = 0, $chss_stand = 0) {

        $point = 1; // -4 и менее +26 и более

        $orthostaticTest = $chss_stand - $chss_lie;

        $data = [];

        if ($gender == 'woman') $data = OrthostaticTest::DATA_WOMAN;
        if ($gender == 'man') $data = OrthostaticTest::DATA_MAN;

        foreach ($data as $key=>$item) {
            if ( $orthostaticTest >= $item[0] && $orthostaticTest <= $item[1] ) {
                $point = $key;
                break;
            }
        }

        return [ $orthostaticTest, $point ];

    }
}