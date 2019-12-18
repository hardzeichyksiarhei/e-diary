<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class Swimming extends Command
{
	use CalculatePoint;

	//<=12
	const DATA_METERS = [ 
		[ 'point' => 2, [25, 49] ], 
		[ 'point' => 3, 50 ] 
	];

	//<= 0.50
	const DATA_WOMAN_SECONDS = [
		[ 'point' => 4, [ 1.16, 1.20 ] ],
		[ 'point' => 5, [ 1.11, 1.15 ] ],
		[ 'point' => 6, [ 1.08, 1.10 ] ],
		[ 'point' => 7, [ 1.05, 1.07 ] ],
		[ 'point' => 8, [ 1.01, 1.04 ] ],
		[ 'point' => 9, [ 0.51, 1 ] ]
 	]; 

	//<= 0.45
	const DATA_MAN_SECONDS = [
		[ 'point' => 4, [ 1.06, 1.10 ] ],
		[ 'point' => 5, [ 1.01, 1.05 ] ],
		[ 'point' => 6, [ 0.58, 1.00 ] ],
		[ 'point' => 7, [ 0.55, 0.57 ] ],
		[ 'point' => 8, [ 0.51, 0.54 ] ],
		[ 'point' => 9, [ 0.46, 0.50 ] ]
	];

	protected $gender, $birthday, $swimming_s, $swimming_m;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:swimming';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Плавание 50 метров';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $swimming_s = null, $swimming_m = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->swimming_s = $swimming_s;
		$this->swimming_m = $swimming_m;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->swimming_s) && is_null($this->swimming_m) ) return 0;

		$data = [];
		$swimming = 0;
		$firstValue = $lastValue = 0;

		if ($this->swimming_m != 0) {
			$data = Swimming::DATA_METERS;
			$swimming = $this->swimming_m;
			$firstValue = 12;
		}

		if ($this->swimming_s != 0 && $this->gender == 'woman') {
			$data = Swimming::DATA_WOMAN_SECONDS;
			$swimming = $this->swimming_s;
			$lastValue = 0.50;
		}

		if ($this->swimming_s != 0 && $this->gender == 'man') {
			$data = Swimming::DATA_MAN_SECONDS;
			$swimming = $this->swimming_s;
			$lastValue = 0.45;
		}

		if ( $this->swimming_m != 0 && $this->swimming_m <= $firstValue ) return 1;
		if ( $this->swimming_s != 0 && $this->swimming_s <= $lastValue ) return 10;

    $point = self::calculatePoint($data, $swimming);

		return $point;
	}
}
