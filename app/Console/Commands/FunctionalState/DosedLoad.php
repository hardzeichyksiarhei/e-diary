<?php

namespace App\Console\Commands\FunctionalState;

use Illuminate\Console\Command;
use App\Traits\CalculatePoint;

class DosedLoad extends Command
{
    use CalculatePoint;

	const DATA_WOMAN = [
		[ 'point' => 2, [ 15, 16.9 ] ],
		[ 'point' => 3, [ 13, 14.9 ] ],
		[ 'point' => 4, [ 11, 12.9 ] ],
		[ 'point' => 5, [ 9, 10.9 ] ],
		[ 'point' => 6, [ 7, 8.9 ] ],
		[ 'point' => 7, [ 5, 6.9 ] ],
		[ 'point' => 8, [ 3, 4.9 ] ],
		[ 'point' => 9, [ 1, 2.9 ] ]
	];

	const DATA_MAN = DosedLoad::DATA_WOMAN;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:dosedLoad';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Проба на дозированную нагрузку';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($gender = 'man', $chss_initial = null, $chss_after_load = null, $chss_restoring = null)
	{
		parent::__construct();
		$this->gender = $gender;
		$this->chss_initial = $chss_initial;
		$this->chss_after_load = $chss_after_load;
		$this->chss_restoring = $chss_restoring;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

    if ( empty($this->chss_initial) || empty($this->chss_after_load) || empty($this->chss_restoring) ) return [ 'value' => null, 'point' => 0 ];

    $dosedLoad = (6 * ( $this->chss_initial + $this->chss_after_load + $this->chss_restoring ) - 200 ) / 10;

		$data = [];

		if ($this->gender == 'woman') $data = DosedLoad::DATA_WOMAN;
		if ($this->gender == 'man') $data = DosedLoad::DATA_MAN;

        if ($dosedLoad >= 17) return [ 'value' => $dosedLoad, 'point' => 1 ];

        if ($dosedLoad <= 0.9) return [ 'value' => $dosedLoad, 'point' => 10 ];

        $point = self::calculatePoint($data, $dosedLoad);

		return [ 'value' => $dosedLoad, 'point' => $point ];
	}
}
