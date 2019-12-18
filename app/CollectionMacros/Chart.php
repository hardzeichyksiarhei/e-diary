<?php
namespace App\CollectionMacros;

use Illuminate\Support\Collection;

/**
 * Array in Chart data.
 *
 * @mixin \Illuminate\Support\Collection
 *
 * @return \Illuminate\Support\Collection
 *
 * @throws \LengthException
 */
class Chart
{
    public function init()
    {
        return function ($semesters, $default = null) {
            if ($this->isEmpty() || empty($semesters)) {
                return new static();
            }
				
						$data = array_fill_keys($semesters, $default);
				
						foreach ($this->toArray() as $key=>$val) {
							foreach ($val as $sub_k=>$sub_val) {
								if ($sub_k != 'semester') {
									$data['semester_' . $val['semester']][$sub_k] = $sub_val;
								}
							}
						}

            return new static($data);
        };
    }
}