<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $this->call( FacultySeeder::class );
	    $this->call( DiseaseGroupSeeder::class );
			$this->call( HealthGroupSeeder::class );
			$this->call( UserSeeder::class );
			//$this->call( MessageSeeder::class );
    }
}
