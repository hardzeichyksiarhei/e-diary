<?php
namespace App\CollectionMacros;

use Illuminate\Support\Collection;

/**
 * Transpose an array.
 *
 * @mixin \Illuminate\Support\Collection
 *
 * @return \Illuminate\Support\Collection
 *
 * @throws \LengthException
 */
class Transpose
{
    public function init()
    {
        return function () {
            if ($this->isEmpty()) {
                return new static();
            }
            $firstItem = $this->first();
            $expectedLength = is_array($firstItem) || $firstItem instanceof Countable ? count($firstItem) : 0;
            array_walk($this->items, function ($row) use ($expectedLength) {
                if ((is_array($row) || $row instanceof Countable) && count($row) !== $expectedLength) {
                    throw new \LengthException("Element's length must be equal.");
                }
            });
            /*$items = array_map(function (...$items) {
                return new static($items);
            }, ...array_map(function ($items) {
                return $this->getArrayableItems($items);
            }, array_values($this->items)));*/

            foreach (array_values($this->items) as $key=>$subarr) {
                $subarr = $this->getArrayableItems($subarr);
                foreach ($subarr as $subkey=>$subvalue) {
                    $items[$subkey][$key] = $subvalue;
                }
            }
            /*$items = [
                'dosed_load_point' => [2, 4, 8, 8, 4],
                'mass_index_point' => [2, 5, 6, 8, 10],
                'orthostatic_test_point' => [2, 6, 6, 3, 10],
                'sample_genchi_point' => [2, 5, 6, 8, 10],
                'sample_shtange_point' => [2, 4, 6, 7, 10]
            ];*/
            return new static($items);
        };
    }
}
