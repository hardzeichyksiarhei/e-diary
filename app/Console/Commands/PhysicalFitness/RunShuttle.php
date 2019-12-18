<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class RunShuttle extends Command
{
	use CalculatePoint;

	// >= 11.9 and <= 10.0
	const DATA_WOMAN_17_18 = [
		[ 'point' => 2, [ 11.6, 11.8 ] ],
		[ 'point' => 3, [ 11.4, 11.5 ] ],
		[ 'point' => 4, [ 11.2, 11.3 ] ],
		[ 'point' => 5, [ 10.9, 11.1 ] ],
		[ 'point' => 6, 10.8 ],
		[ 'point' => 7, [ 10.6, 10.7 ] ],
		[ 'point' => 8, [ 10.3, 10.5 ] ],
		[ 'point' => 9, [ 10.1, 10.2 ] ]
	];

	// >= 12.7 and <= 10.0
	const DATA_WOMAN_19_22 = [
		[ 'point' => 2, [ 12.2, 12.6 ] ],
		[ 'point' => 3, [ 12.0, 12.1 ] ],
		[ 'point' => 4, [ 11.7, 11.9 ] ],
		[ 'point' => 5, [ 11.3, 11.6 ] ],
		[ 'point' => 6, [ 11.1, 11.2 ] ],
		[ 'point' => 7, [ 10.9, 11.0 ] ],
		[ 'point' => 8, [ 10.7, 10.8 ] ],
		[ 'point' => 9, [ 10.1, 10.6 ] ]
	];

	// >= 10.7 and <= 8.6
	const DATA_MAN_17_18 = [
		[ 'point' => 2, [ 10.4, 10.6 ] ],
		[ 'point' => 3, [ 10.1, 10.3 ] ],
		[ 'point' => 4, [ 9.9, 10.0 ] ],
		[ 'point' => 5, [ 9.7, 9.8 ] ],
		[ 'point' => 6, [ 9.5, 9.6 ] ],
		[ 'point' => 7, [ 9.3, 9.4 ] ],
		[ 'point' => 8, [ 9.0, 9.2 ] ],
		[ 'point' => 9, [ 8.7, 8.9 ] ]
	];

	// >= 10.9 and <= 8.9
	const DATA_MAN_19_22 = [
		[ 'point' => 2, [ 10.4, 10.8 ] ],
		[ 'point' => 3, [ 10.1, 10.3 ] ],
		[ 'point' => 4, [ 9.9, 10.0 ] ],
		[ 'point' => 5, [ 9.7, 9.8 ] ],
		[ 'point' => 6, [ 9.5, 9.6 ] ],
		[ 'point' => 7, 9.4 ],
		[ 'point' => 8, [ 9.2, 9.3 ] ],
		[ 'point' => 9, [ 9.0, 9.1 ] ]
	];

	protected $gender, $age, $run_shuttle;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:runShuttle';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Челночный бег 4 х 9 м, с';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $run_shuttle = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->run_shuttle = $run_shuttle;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->run_shuttle) ) return 0;
    
		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
				$data = RunShuttle::DATA_WOMAN_17_18;
				$firstValue = 11.9;
				$lastValue = 10.0;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
				$data = RunShuttle::DATA_WOMAN_19_22;
				$firstValue = 12.7;
				$lastValue = 10.0;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = RunShuttle::DATA_MAN_17_18;
				$firstValue = 10.7;
				$lastValue = 8.6;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = RunShuttle::DATA_MAN_19_22;
				$firstValue = 10.9;
				$lastValue = 8.9;
		}

		if ( $this->run_shuttle >= $firstValue ) return 1;
		if ( $this->run_shuttle <= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->run_shuttle);

		return $point;
	}
}
