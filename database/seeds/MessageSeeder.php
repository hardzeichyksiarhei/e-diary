<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$faker = Faker\Factory::create();

			factory(App\Message::class, 300)->create()->each(function ($msg) use ($faker) {
				$created_at = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now');
        $msg->messagesStatus()->create([
          'user_id' => $msg->sender_id,
					'is_starred' => 0,
          'is_read' => array_random([0, 1]),
          'folder' => 'sent',
          'status' => 'active',
					'created_at' => $created_at,
					'updated_at' => $created_at
        ]);
        $msg->messagesStatus()->create([
          'user_id' => array_random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
					'is_starred' => 0,
          'is_read' => array_random([0, 1]),
          'folder' => 'inbox',
          'status' => 'active',
					'created_at' => $created_at,
					'updated_at' => $created_at
				]);
    	});
    }
}
