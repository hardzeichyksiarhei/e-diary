<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FunctionalState\DosedLoad::class,
        Commands\FunctionalState\MassIndex::class,
        Commands\FunctionalState\OrthostaticTest::class,
        Commands\FunctionalState\SampleGenchi::class,
        Commands\FunctionalState\SampleShtange::class,

        Commands\PhysicalFitness\LongJump::class,
        Commands\PhysicalFitness\Press::class,
        Commands\PhysicalFitness\PullUp::class,
        Commands\PhysicalFitness\PushUp::class,
        Commands\PhysicalFitness\RunLong::class,
        Commands\PhysicalFitness\RunShort::class,
        Commands\PhysicalFitness\RunShuttle::class,
        Commands\PhysicalFitness\Swimming::class,
        Commands\PhysicalFitness\TorsoInclination::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
