<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class PushUp extends Command
{
	use CalculatePoint;

	//<=3 and >=22
	const DATA_WOMAN_17_18=[
		[ 'point' => 2, 4 ],
		[ 'point' => 3, [5,6] ],
		[ 'point' => 4, [7,8] ],
		[ 'point' => 5, 9 ],
		[ 'point' => 6, [10,11] ],
		[ 'point' => 7, [12,14] ],
		[ 'point' => 8, [15,19] ],
		[ 'point' => 9, [20,21] ],
	]; 

	//<=3 and >=21
	const DATA_WOMAN_19_22=[
		[ 'point' => 2, 4 ],
		[ 'point' => 3, 5 ],
		[ 'point' => 4, [6,7] ],
		[ 'point' => 5, [8,9] ],
		[ 'point' => 6, [10,11] ],
		[ 'point' => 7, 12 ],
		[ 'point' => 8, [13,16] ],
		[ 'point' => 9, [17,20] ],
	]; 

	//<=26 and >=73
	const DATA_MAN_17_18=[
		[ 'point' => 2, [17,29] ],
		[ 'point' => 3, [30,32] ],
		[ 'point' => 4, [33,34] ],
		[ 'point' => 5, [35,37] ],
		[ 'point' => 6, [38,39] ],
		[ 'point' => 7, [40,47] ],
		[ 'point' => 8, [48,49] ],
		[ 'point' => 9, [50,72] ],
	]; 

	//<=23 and >=70
	const DATA_MAN_19_22=[
		[ 'point' => 2, [24,26] ],
		[ 'point' => 3, [27,29] ],
		[ 'point' => 4, [30,34] ],
		[ 'point' => 5, [35,39] ],
		[ 'point' => 6, [40,43] ],
		[ 'point' => 7, [44,46] ],
		[ 'point' => 8, [47,54] ],
		[ 'point' => 9, [55,69] ],
	]; 

	protected $gender, $age, $push_up;
		
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:pushUp';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Сгибание и разгибание рук в упоре лежа, раз';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $push_up = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->push_up = $push_up;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->push_up) ) return 0;

		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
				$data = PushUp::DATA_WOMAN_17_18;
				$firstValue = 3;
				$lastValue = 22;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
				$data = PushUp::DATA_WOMAN_19_22;
				$firstValue = 3;
				$lastValue = 21;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = PushUp::DATA_MAN_17_18;
				$firstValue = 26;
				$lastValue = 73;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = PushUp::DATA_MAN_19_22;
				$firstValue = 23;
				$lastValue = 70;
		}

		if ( $this->push_up <= $firstValue ) return 1;
		if ( $this->push_up >= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->push_up);

		return $point;
	}
}
