<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class PullUp extends Command
{
	use CalculatePoint;

	//<=3 and >=25
	const DATA_MAN_17_18=[
		[ 'point' => 2, 4 ],
		[ 'point' => 3, [5,6] ],
		[ 'point' => 4, [7,8] ],
		[ 'point' => 5, 9 ],
		[ 'point' => 6, [10,12] ],
		[ 'point' => 7, 13 ],
		[ 'point' => 8, [14,16] ],
		[ 'point' => 9, [17,24] ],
	]; 

	//<=5 and >=33
	const DATA_MAN_19_22=[
		[ 'point' => 2, [6,8] ],
		[ 'point' => 3, 9 ],
		[ 'point' => 4, 10 ],
		[ 'point' => 5, [11,12] ],
		[ 'point' => 6, [13,14] ],
		[ 'point' => 7, 15 ],
		[ 'point' => 8, [16,19] ],
		[ 'point' => 9, [20,32] ],
	]; 

	protected $gender, $age, $pull_up;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:pullUp';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Подтягивание на высокой перекладине, раз';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $pull_up = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
		$this->pull_up = $pull_up;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->pull_up) ) return 0;

		if ($this->gender == 'woman') return 0;

		$data = [];

		$firstValue = $lastValue = 0;
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
				$data = PullUp::DATA_MAN_17_18;
				$firstValue = 3;
				$lastValue = 25;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
				$data = PullUp::DATA_MAN_19_22;
				$firstValue = 5;
				$lastValue = 33;
		}

		if ( $this->pull_up <= $firstValue ) return 1;
		if ( $this->pull_up >= $lastValue ) return 10;

		$point = self::calculatePoint($data, $this->pull_up);

		return $point;
	}
}
