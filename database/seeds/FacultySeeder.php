<?php

use App\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $faculties = [
	    	'Физико-математический факультет',
		    'Филологический факультет',
				'Исторический факультет',
				'Институт психологии',
				'Институт инклюзивного образования',
		    'Факультет эстетического образования',
		    'Факультет начального образования',
		    'Факультет дошкольного образования',
		    'Факультет социально-педагогических технологий',
				'Факультет естествознания'
	    ];

	    foreach ($faculties as $faculty) {
		    Faculty::create([
			    'name' => $faculty
		    ]);
	    }
    }
}
