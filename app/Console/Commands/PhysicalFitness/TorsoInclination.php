<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class TorsoInclination extends Command
{
	use CalculatePoint;

	// <= 6 and >= 25
	const DATA_WOMAN_17_18 = [
		[ 'point' => 2, [ 7, 8 ] ],
		[ 'point' => 3, [ 9, 10 ] ],
		[ 'point' => 4, [ 11, 12 ] ],
		[ 'point' => 5, [ 13, 14 ] ],
		[ 'point' => 6, [ 15, 16 ] ],
		[ 'point' => 7, [ 17, 18 ] ],
		[ 'point' => 8, [ 19, 21 ] ],
		[ 'point' => 9, [ 22, 24 ] ]
	];

	// <= 6 and >= 28
	const DATA_WOMAN_19_22 = [
		[ 'point' => 2, [ 7, 10 ] ],
		[ 'point' => 3, 11 ],
		[ 'point' => 4, [ 12, 13 ] ],
		[ 'point' => 5, [ 14, 15 ] ],
		[ 'point' => 6, [ 16, 18 ] ],
		[ 'point' => 7, 19 ],
		[ 'point' => 8, [ 20, 23 ] ],
		[ 'point' => 9, [ 24, 27 ] ]
	];

	// <= 1 and >= 21
	const DATA_MAN_17_18 = [
		[ 'point' => 2, [ 2, 4 ] ],
		[ 'point' => 3, [ 5, 7 ] ],
		[ 'point' => 4, [ 8, 9 ] ],
		[ 'point' => 5, [ 10, 12 ] ],
		[ 'point' => 6, 13 ],
		[ 'point' => 7, [ 14, 15 ] ],
		[ 'point' => 8, [ 16, 18 ] ],
		[ 'point' => 9, [ 19, 20 ] ]
	];

	// <= 3 and >= 25
	const DATA_MAN_19_22 = [
		[ 'point' => 2, [ 4, 6 ] ],
		[ 'point' => 3, [ 7, 8 ] ],
		[ 'point' => 4, [ 9, 10 ] ],
		[ 'point' => 5, [ 11, 12 ] ],
		[ 'point' => 6, [ 13, 14 ] ],
		[ 'point' => 7, [ 15, 16 ] ],
		[ 'point' => 8, [ 17, 20 ] ],
		[ 'point' => 9, [ 21, 24 ] ]
	];

	protected $gender, $age, $torso_inclination;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:torsoInclination';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Наклон туловища вперед, см';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $torso_inclination = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->torso_inclination = $torso_inclination;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->torso_inclination) ) return 0;

		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
				$data = TorsoInclination::DATA_WOMAN_17_18;
				$firstValue = 6;
				$lastValue = 25;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
				$data = TorsoInclination::DATA_WOMAN_19_22;
				$firstValue = 6;
				$lastValue = 28;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = TorsoInclination::DATA_MAN_17_18;
				$firstValue = 1;
				$lastValue = 21;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = TorsoInclination::DATA_MAN_19_22;
				$firstValue = 3;
				$lastValue = 25;
		}

		if ( $this->torso_inclination <= $firstValue ) return 1;
		if ( $this->torso_inclination >= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->torso_inclination);

		return $point;
	}
}
