<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class LongJump extends Command
{
	use CalculatePoint;

	// <= 154 and >= 202
	const DATA_WOMAN_17_18 = [
		[ 'point' => 2, [ 155, 164 ] ],
		[ 'point' => 3, [ 165, 169 ] ],
		[ 'point' => 4, [ 170, 174 ] ],
		[ 'point' => 5, [ 175, 177 ] ],
		[ 'point' => 6, [ 178, 179 ] ],
		[ 'point' => 7, [ 180, 189 ] ],
		[ 'point' => 8, [ 190, 195 ] ],
		[ 'point' => 9, [ 196, 201 ] ]
	];

	// <= 149 and >= 205
	const DATA_WOMAN_19_22 = [
		[ 'point' => 2, [ 150, 159 ] ],
		[ 'point' => 3, [ 160, 164 ] ],
		[ 'point' => 4, [ 165, 169 ] ],
		[ 'point' => 5, [ 170, 173 ] ],
		[ 'point' => 6, [ 174, 179 ] ],
		[ 'point' => 7, [ 180, 183 ] ],
		[ 'point' => 8, [ 184, 189 ] ],
		[ 'point' => 9, [ 190, 204 ] ]
	];

	// <= 204 and >= 265
	const DATA_MAN_17_18 = [
		[ 'point' => 2, [ 205, 209 ] ],
		[ 'point' => 3, [ 210, 219 ] ],
		[ 'point' => 4, [ 220, 224 ] ],
		[ 'point' => 5, [ 225, 229 ] ],
		[ 'point' => 6, [ 230, 234 ] ],
		[ 'point' => 7, [ 235, 239 ] ],
		[ 'point' => 8, [ 240, 249 ] ],
		[ 'point' => 9, [ 250, 264 ] ]
	];

	// <= 204 and >= 265
	const DATA_MAN_19_22 = [
		[ 'point' => 2, [ 205, 217 ] ],
		[ 'point' => 3, [ 218, 221 ] ],
		[ 'point' => 4, [ 222, 229 ] ],
		[ 'point' => 5, [ 230, 232 ] ],
		[ 'point' => 6, [ 233, 239 ] ],
		[ 'point' => 7, [ 240, 244 ] ],
		[ 'point' => 8, [ 245, 254 ] ],
		[ 'point' => 9, [ 255, 264 ] ]
	];

	protected $gender, $age, $long_jump;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:longJump';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Прыжок в длину с места';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $age = 0, $long_jump = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->long_jump = $long_jump;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->long_jump) ) return 0;

		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
			$data = LongJump::DATA_WOMAN_17_18;
			$firstValue = 154;
			$lastValue = 202;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
			$data = LongJump::DATA_WOMAN_19_22;
			$firstValue = 149;
			$lastValue = 205;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
			$data = LongJump::DATA_MAN_17_18;
			$firstValue = 204;
			$lastValue = 265;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
			$data = LongJump::DATA_MAN_19_22;
			$firstValue = 204;
			$lastValue = 265;
		}

		if ( $this->long_jump <= $firstValue ) return 1;
    if ( $this->long_jump >= $lastValue ) return 10;
        
    $point = self::calculatePoint($data, $this->long_jump);

		return $point;
	}
}
