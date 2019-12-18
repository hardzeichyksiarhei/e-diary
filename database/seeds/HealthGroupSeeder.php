<?php

use App\HealthGroup;
use Illuminate\Database\Seeder;

class HealthGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $healthGroups = [
		    'Основная',
		    'Подготовительная',
		    'Специально медицинская (СМГ)',
		    'Лечебно физической культуры (ЛФК)',
		    'Освобожденные от занятий физической культурой'
	    ];

	    foreach ($healthGroups as $group) {
		    HealthGroup::create([
			    'name' => $group
		    ]);
	    }
    }
}
