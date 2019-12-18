<?php

namespace App\Console\Commands\FunctionalState;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class MassIndex extends Command
{
    use CalculatePoint;

	const DATA_WOMAN = [
		[ 'point' => 2, -16, 9 ],
		[ 'point' => 3, -15, 8 ],
		[ 'point' => 4, -14, 7 ],
		[ 'point' => 5, -13, 6 ],
		[ 'point' => 6, -12, 5 ],
		[ 'point' => 7, -11, [ 3, 4 ] ],
		[ 'point' => 8, [ -10, -9 ], [ 1, 2 ] ],
		[ 'point' => 9, [ -8, -6 ] ],
		[ 'point' => 10, [ -5, 0 ] ]
	];

	const DATA_MAN = MassIndex::DATA_WOMAN;

	protected $gender, $mass, $length;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:massIndex';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Росто-масовый показатель';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $mass = null, $length = null)
	{
			parent::__construct();
			$this->gender = $gender;
			$this->mass = $mass;
			$this->length = $length;
	}

	private static function getCoefficient ($length)
	{
		if ($length <= 155) return 95;
		elseif ($length >= 156 && $length <= 165) return 100;
		elseif ($length >= 166 && $length <= 175) return 105;
		else return 110;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
    if (is_null($this->mass) || is_null($this->length)) return [ 'value' => null, 'point' => 0 ];

		$coefficient = MassIndex::getCoefficient($this->length);

		$massIndex = $this->mass - ( $this->length - $coefficient );

		$data = [];

		if ($this->gender == 'woman') $data = MassIndex::DATA_WOMAN;
        if ($this->gender == 'man') $data = MassIndex::DATA_MAN;

        if ($massIndex <= -17 && $massIndex >= 10) return [ 'value' => $massIndex, 'point' => 1 ];

        $point = self::calculatePoint($data, $massIndex);

		return [ 'value' => $massIndex, 'point' => $point ];
	}
}
