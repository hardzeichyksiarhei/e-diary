<?php

namespace App\Console\Commands\PhysicalFitness;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class RunShort extends Command
{
	use CalculatePoint;

	//>=6.2 and <=4.8
	const DATA_WOMAN_17_18 = [
		[ 'point' => 2, [5.9,6.1] ],
		[ 'point' => 3, [5.7,5.8] ],
		[ 'point' => 4, [5.5,5.6] ],
		[ 'point' => 5, 5.4 ],
		[ 'point' => 6, 5.3 ],
		[ 'point' => 7, 5.2 ],
		[ 'point' => 8, 5.1 ],
		[ 'point' => 9, [4.9,5.0] ],
	]; 
	
	//>=6.6 and <=5.0
	const DATA_WOMAN_19_22=[
		[ 'point' => 2, [6.3,6.5] ],
		[ 'point' => 3, [6.1,6.2] ],
		[ 'point' => 4, [5.8,6.0] ],
		[ 'point' => 5, [5.6,5.7] ],
		[ 'point' => 6, 5.5 ],
		[ 'point' => 7, 5.4 ],
		[ 'point' => 8, 5.3 ],
		[ 'point' => 9, [5.1,5.2] ],
	]; 
	
	//>=5.1 and <=4.1
	const DATA_MAN_17_18=[
		[ 'point' => 2, 5 ],
		[ 'point' => 3, 4.9 ],
		[ 'point' => 4, 4.8 ],
		[ 'point' => 5, 4.7 ],
		[ 'point' => 6, 4.6 ],
		[ 'point' => 7, 4.5 ],
		[ 'point' => 8, 4.4 ],
		[ 'point' => 9, [4.2,4.3] ],
	]; 
	
	//>=5.3 and <=4.2
	const DATA_MAN_19_22=[
		[ 'point' => 2, [5.1,5.2] ],
		[ 'point' => 3, 5 ],
		[ 'point' => 4, [4.8,4.9] ],
		[ 'point' => 5, 4.7 ],
		[ 'point' => 6, 4.6 ],
		[ 'point' => 7, 4.5 ],
		[ 'point' => 8, 4.4 ],
		[ 'point' => 9, 4.3 ],
	];

	protected $gender, $age, $run_short;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:runShort';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Бег 30 м (сек)';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = '', $age = 0, $run_short = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->age = $age;
    $this->run_short = $run_short;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->run_short) ) return 0;
    
		$data = [];

		$firstValue = $lastValue = 0;

		if ($this->gender == 'woman' && $this->age >= 17 && $this->age <= 18) {
            $data = RunShort::DATA_WOMAN_17_18;
            $firstValue = 6.2;
            $lastValue = 4.8;
		}

		if ($this->gender == 'woman' && $this->age >= 19 && $this->age <= 22) {
            $data = RunShort::DATA_WOMAN_19_22;
            $firstValue = 6.6;
            $lastValue = 5.0;
		}
		
		if ($this->gender == 'man' && $this->age >= 17 && $this->age <= 18) {
            $data = RunShort::DATA_MAN_17_18;
            $firstValue = 5.1;
            $lastValue = 4.1;
		}
		
		if ($this->gender == 'man' && $this->age >= 19 && $this->age <= 22) {
            $data = RunShort::DATA_MAN_19_22;
            $firstValue = 5.3;
            $lastValue = 4.2;
		}

		if ( $this->run_short >= $firstValue ) return 1;
		if ( $this->run_short <= $lastValue ) return 10;
		
		$point = self::calculatePoint($data, $this->run_short);

		return $point;
	}
}
