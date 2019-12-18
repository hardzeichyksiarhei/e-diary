<?php

namespace App\Traits;

trait CalculatePoint {

	public static function calculatePoint($data, $value) {
    $point = 1;
		foreach ($data as $key=>$item) {
        $array_size = count($item) - 1;

        // Сравнение с одним числом
        if ( $array_size == 1 && !is_array($item[0]) && $value == $item[0] ) {
            $point = $item['point'];
            break;
        }

        // Сравнение с двумя числами (хотя бы одно совпадение)
        if ( $array_size == 2 && !is_array($item[0]) && !is_array($item[1]) && ( $value == $item[0] || $value == $item[1] ) ) {
            $point = $item['point'];
            break;
        }

        // Сравнение с отрезком (принадлежит отрезку)
        if ( $array_size == 1 && is_array($item[0]) && ( $value >= $item[0][0] && $value <= $item[0][1] ) ) {
            $point = $item['point'];
            break;
        }

        // Сравнение с двумя отрезками (принадлежит хотя бы одному)
        if ( $array_size == 2 && is_array($item[0]) && is_array($item[1]) && ( ($value >= $item[0][0] && $value <= $item[0][1]) || ($value >= $item[1][0] && $value <= $item[1][1]) ) ) {
            $point = $item['point'];
            break;
        }

        // Сравнение с числом и отрезком (совпадает с числом или принадлежит отрезку)
        if ( $array_size == 2 && !is_array($item[0]) && is_array($item[1]) && ( $value == $item[0] || $value >= $item[1][0] && $value <= $item[1][1] ) ) {
            $point = $item['point'];
            break;
        }
    }
    return $point;
	}	

}