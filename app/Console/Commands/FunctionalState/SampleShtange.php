<?php

namespace App\Console\Commands\FunctionalState;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class SampleShtange extends Command
{
    use CalculatePoint;

	const DATA_WOMAN = [
		[ 'point' => 2, [ 20, 22 ] ],
		[ 'point' => 3, [ 23, 25 ] ],
		[ 'point' => 4, [ 26, 28 ] ],
		[ 'point' => 5, [ 29, 31 ] ],
		[ 'point' => 6, [ 32, 34 ] ],
		[ 'point' => 7, [ 35, 37 ] ],
		[ 'point' => 8, [ 38, 40 ] ],
		[ 'point' => 9, [ 41, 43 ] ]
	];

	const DATA_MAN = [
		[ 'point' => 2, [ 29, 31 ] ],
		[ 'point' => 3, [ 32, 34 ] ],
		[ 'point' => 4, [ 35, 37 ] ],
		[ 'point' => 5, [ 38, 40 ] ],
		[ 'point' => 6, [ 41, 43 ] ],
		[ 'point' => 7, [ 44, 46 ] ],
		[ 'point' => 8, [ 47, 49 ] ],
		[ 'point' => 9, [ 50, 52 ] ]
	];

	protected $gender, $sample_shtange;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:sampleShtange';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Проба Штанге';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $sample_shtange = null)
	{
			parent::__construct();
			$this->gender = $gender;
			$this->sample_shtange = $sample_shtange;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->sample_shtange) ) return 0;

		$data = [];

		if ($this->gender == 'woman') $data = SampleShtange::DATA_WOMAN;
		if ($this->gender == 'man') $data = SampleShtange::DATA_MAN;

		if ( $this->gender == 'woman' && $this->sample_shtange <= 19 ) return 1; // 19 и менее
		if ( $this->gender == 'woman' && $this->sample_shtange >= 44 ) return 10; // 44 и более

		if ( $this->gender == 'man' && $this->sample_shtange <= 28 ) return 1; // 28 и менее
        if ( $this->gender == 'man' && $this->sample_shtange >= 53 ) return 10; // 53 и более

        $point = self::calculatePoint($data, $this->sample_shtange);

		return $point;
	}
}
