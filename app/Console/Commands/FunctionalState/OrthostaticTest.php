<?php

namespace App\Console\Commands\FunctionalState;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class OrthostaticTest extends Command
{
    use CalculatePoint;

	const DATA_WOMAN = [
		[ 'point' => 2, [ 24, 25 ], [ -3, -1 ] ],
		[ 'point' => 3, [ 22, 23 ] ],
		[ 'point' => 4, [ 20, 21 ] ],
		[ 'point' => 5, [ 17, 19 ] ],
		[ 'point' => 6, [ 14, 16 ] ],
		[ 'point' => 7, [ 11, 13 ] ],
		[ 'point' => 8, [ 8, 10 ] ],
		[ 'point' => 9, [ 4, 7 ] ],
		[ 'point' => 10, [ 0, 3 ] ]
	];

	const DATA_MAN = OrthostaticTest::DATA_WOMAN;

	protected $gender, $chss_lie, $chss_stand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:orthostaticTest';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Ортостатическая проба';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $chss_lie = null, $chss_stand = null)
	{
			parent::__construct();
			$this->gender = $gender;
			$this->chss_lie = $chss_lie;
			$this->chss_stand = $chss_stand;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( is_null($this->chss_stand) || is_null($this->chss_lie) ) return [ 'value' => null, 'point' => 0 ];

		$orthostaticTest = $this->chss_stand - $this->chss_lie;

		$data = [];

		if ($this->gender == 'woman') $data = OrthostaticTest::DATA_WOMAN;
    if ($this->gender == 'man') $data = OrthostaticTest::DATA_MAN;

    if ($orthostaticTest <= -4 && $orthostaticTest >= 26) return [ 'value' => $orthostaticTest, 'point' => 1 ];

    $point = self::calculatePoint($data, $orthostaticTest);

		return [ 'value' => $orthostaticTest, 'point' => $point ];
	}

}
