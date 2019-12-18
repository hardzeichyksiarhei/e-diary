<?php

namespace App\PhysicalFitness;

use App\Traits\CalculateAge;
use Illuminate\Support\Collection;

class Press {
	use CalculateAge;

    const NAME = 'Поднимание туловища из положения лежа на спине за 60 с, раз';

    //<=37 and >=60
    const DATA_WOMAN_17_18=[
        2=>[38,41],
        3=>[42,44],
        4=>[45,46],
        5=>[47,48],
        6=>49,
        7=>[50,51],
        8=>[52,57],
        9=>[58,59],
    ]; 

    //<=29 and >=56
    const DATA_WOMAN_19_22=[
        2=>[30,33],
        3=>[34,36],
        4=>[37,39],
        5=>[40,41],
        6=>[42,44],
        7=>[45,46],
        8=>[47,50],
        9=>[51,55],
    ]; 

    //<=37 and >=73
    const DATA_MAN_17_18=[
        2=>[38,39],
        3=>[40,41],
        4=>[42,45],
        5=>[46,48],
        6=>[49,50],
        7=>[51,59],
        8=>[60,62],
        9=>[63,72],
    ]; 

    //<=34 and >=60
    const DATA_MAN_19_22=[
        2=>[35,38],
        3=>[39,40],
        4=>[41,43],
        5=>[44,45],
        6=>[46,47],
        7=>[48,50],
        8=>[51,54],
        9=>[55,59],
    ]; 

    public static function getPressPoint ($gender, $birthday, $press = 0) {

        $data = [];

				$firstValue = $lastValue = 0;
				
				$age = self::calculateAge($birthday);

        if ($gender == 'woman' && $age >= 17 && $age <= 18) {
            $data = Press::DATA_WOMAN_17_18;
            $firstValue = 37;
            $lastValue = 60;
        }

        if ($gender == 'woman' && $age >= 19 && $age <= 22) {
            $data = Press::DATA_WOMAN_19_22;
            $firstValue = 29;
            $lastValue = 56;
        }
        
        if ($gender == 'man' && $age >= 17 && $age <= 18) {
            $data = Press::DATA_MAN_17_18;
            $firstValue = 37;
            $lastValue = 73;
        }
        
        if ($gender == 'man' && $age >= 19 && $age <= 22) {
            $data = Press::DATA_MAN_19_22;
            $firstValue = 34;
            $lastValue = 60;
        }

        $point = 0;

        $flag = false;

        foreach ($data as $key=>$item) {
            if ( $press >= $item[0] && $press <= $item[1] ) {
                $point = $key;
                $flag = true;
                break;
            }
        }

        if ( !$flag && $press <= $firstValue ) $point = 1;
        if ( !$flag && $press >= $lastValue ) $point = 10;

        return $point;

    }
}