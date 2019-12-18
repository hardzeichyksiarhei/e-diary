<?php

namespace App\Console\Commands\FunctionalState;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class SampleGenchi extends Command
{
    use CalculatePoint;

	const DATA_WOMAN = [
		[ 'point' => 2, [ 15, 16 ] ],
		[ 'point' => 3, [ 17, 18 ] ],
		[ 'point' => 4, [ 19, 20 ] ],
		[ 'point' => 5, [ 21, 22 ] ],
		[ 'point' => 6, [ 23, 24 ] ],
		[ 'point' => 7, [ 25, 26 ] ],
		[ 'point' => 8, [ 27, 28 ] ],
		[ 'point' => 9, [ 29, 30 ] ]
	];

	const DATA_MAN = [
		[ 'point' => 2, [ 19, 21 ] ],
		[ 'point' => 3, [ 22, 24 ] ],
		[ 'point' => 4, [ 25, 27 ] ],
		[ 'point' => 5, [ 28, 30 ] ],
		[ 'point' => 6, [ 31, 33 ] ],
		[ 'point' => 7, [ 34, 36 ] ],
		[ 'point' => 8, [ 37, 39 ] ],
		[ 'point' => 9, [ 40, 42 ] ]
	];

	protected $gender, $sample_genchi;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:sampleGenchi';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Проба Генчи';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $sample_genchi = null)
	{
			parent::__construct();
			$this->gender = $gender;
			$this->sample_genchi = $sample_genchi;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->sample_genchi) ) return 0;

		$data = [];

		if ($this->gender == 'woman') $data = SampleGenchi::DATA_WOMAN;
		if ($this->gender == 'man') $data = SampleGenchi::DATA_MAN;

		if ( $this->gender == 'woman' && $this->sample_genchi <= 14 ) return 1; // 14 и менее
		if ( $this->gender == 'woman' && $this->sample_genchi >= 31 ) return 10; // 31 и более

		if ( $this->gender == 'man' && $this->sample_genchi <= 18 ) return 1; // 18 и менее
        if ( $this->gender == 'man' && $this->sample_genchi >=43 ) return 10; // 43 и более
        
        $point = self::calculatePoint($data, $this->sample_genchi);

		return $point;
	}
}
