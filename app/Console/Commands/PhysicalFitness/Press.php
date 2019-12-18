<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class Press extends Command
{
	use CalculatePoint;

	//<=37 and >=60
	const DATA_WOMAN_17_18=[
		[ 'point' => 2, [38,41] ],
		[ 'point' => 3, [42,44] ],
		[ 'point' => 4, [45,46] ],
		[ 'point' => 5, [47,48] ],
		[ 'point' => 6, 49 ],
		[ 'point' => 7, [50,51] ],
		[ 'point' => 8, [52,57] ],
		[ 'point' => 9, [58,59] ],
	]; 

	//<=29 and >=56
	const DATA_WOMAN_19_22=[
		[ 'point' => 2, [30,33] ],
		[ 'point' => 3, [34,36] ],
		[ 'point' => 4, [37,39] ],
		[ 'point' => 5, [40,41] ],
		[ 'point' => 6, [42,44] ],
		[ 'point' => 7, [45,46] ],
		[ 'point' => 8, [47,50] ],
		[ 'point' => 9, [51,55] ],
	]; 

	//<=37 and >=73
	const DATA_MAN_17_18=[
		[ 'point' => 2, [38,39] ],
		[ 'point' => 3, [40,41] ],
		[ 'point' => 4, [42,45] ],
		[ 'point' => 5, [46,48] ],
		[ 'point' => 6, [49,50] ],
		[ 'point' => 7, [51,59] ],
		[ 'point' => 8, [60,62] ],
		[ 'point' => 9, [63,72] ],
	]; 

	//<=34 and >=60
	const DATA_MAN_19_22=[
		[ 'point' => 2, [35,38] ],
		[ 'point' => 3, [39,40] ],
		[ 'point' => 4, [41,43] ],
		[ 'point' => 5, [44,45] ],
		[ 'point' => 6, [46,47] ],
		[ 'point' => 7, [48,50] ],
		[ 'point' => 8, [51,54] ],
		[ 'point' => 9, [55,59] ],
	]; 

	protected $gender, $age, $press;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:press';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Поднимание туловища из положения лежа на спине за 60 с, раз';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $press = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->press = $press;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->press) ) return 0;
    
		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
				$data = Press::DATA_WOMAN_17_18;
				$firstValue = 37;
				$lastValue = 60;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
				$data = Press::DATA_WOMAN_19_22;
				$firstValue = 29;
				$lastValue = 56;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = Press::DATA_MAN_17_18;
				$firstValue = 37;
				$lastValue = 73;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = Press::DATA_MAN_19_22;
				$firstValue = 34;
				$lastValue = 60;
		}

		if ( $this->press <= $firstValue ) return 1;
		if ( $this->press >= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->press);

		return $point;
	}
}
