<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class RunLong extends Command
{
	use CalculatePoint;

	//>=8.30 and <=4.05
	const DATA_WOMAN_17_18=[
		[ 'point' => 2, 8.29 ],
		[ 'point' => 3, [7.04, 8.28] ],
		[ 'point' => 4, [7.02, 7.03] ],
		[ 'point' => 5, [6.49, 7.01] ],
		[ 'point' => 6, [6.18, 6.48] ],
		[ 'point' => 7, [4.49, 6.17] ],
		[ 'point' => 8, [4.46, 4.48] ],
		[ 'point' => 9, [4.06, 4.45] ],
	]; 

	//>=9.28 and <=6.30
	const DATA_WOMAN_19_22=[
		[ 'point' => 2, [8.50,9.27] ],
		[ 'point' => 3, [8.04,8.49] ],
		[ 'point' => 4, [8.01,8.03] ],
		[ 'point' => 5, [7.53, 8.0] ],
		[ 'point' => 6, [7.42, 7.52] ],
		[ 'point' => 7, [7.26, 7.41] ],
		[ 'point' => 8, [7.01, 7.25] ],
		[ 'point' => 9, [6.31, 7.00] ],
	];

	//>=16.03 and <=11.05
	const DATA_MAN_17_18=[
		[ 'point' => 2, [15.30,16.02] ],
		[ 'point' => 3, [14.46,15.29] ],
		[ 'point' => 4, [14.06,14.45] ],
		[ 'point' => 5, [13.06,14.05] ],
		[ 'point' => 6, [12.05,13.05] ],
		[ 'point' => 7, [12.02,12.04] ],
		[ 'point' => 8, [11.34,12.01] ],
		[ 'point' => 9, [11.06,11.33] ],
	]; 
	
	//>=13.18 and <=11.01
	const DATA_MAN_19_22=[
		[ 'point' => 2, [12.07,13.17] ],
		[ 'point' => 3, [12.02,12.06] ],
		[ 'point' => 4, 12.01 ],
		[ 'point' => 5, [11.27,12.00] ],
		[ 'point' => 6, [11.07,11.26] ],
		[ 'point' => 7, [11.05,11.06] ],
		[ 'point' => 8, 11.04 ],
		[ 'point' => 9, [11.02,11.03] ],
	]; 

	protected $gender, $age, $run_long;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:runLong';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Бег 1500/3000 м (мин. сек)';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $run_long = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->run_long = $run_long;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->run_long) ) return 0;
    
		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
				$data = RunLong::DATA_WOMAN_17_18;
				$firstValue = 8.30;
				$lastValue = 4.05;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
				$data = RunLong::DATA_WOMAN_19_22;
				$firstValue = 9.28;
				$lastValue = 6.30;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = RunLong::DATA_MAN_17_18;
				$firstValue = 16.03;
				$lastValue = 11.05;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = RunLong::DATA_MAN_19_22;
				$firstValue = 13.18;
				$lastValue = 11.01;
		}

		if ( $this->run_long >= $firstValue ) return 1;
		if ( $this->run_long <= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->run_long);

		return $point;
	}
}
