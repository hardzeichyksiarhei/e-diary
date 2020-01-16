<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$admin1 = [
				'first_name' => 'Сергей',
				'last_name' => 'Гардейчик',
				'name' => 'Гардейчик Сергей',
				'email' => 'hardzeichyksiarhei@gmail.com',
				'password' => Hash::make('123456'),
				'role' => 'admin'
			];

			$admin2 = [
				'first_name' => 'admin',
				'last_name' => 'admin',
				'name' => 'admin admin',
				'email' => 'admin@admin.admin',
				'password' => Hash::make('123456'),
				'role' => 'admin'
			];

			$teacher1 = [
				'first_name' => 'Анна',
				'last_name' => 'Кукель',
				'name' => 'Кукель Анна',
				'email' => 'teacher@teacher.teacher',
				'password' => Hash::make('123456'),
				'role' => 'teacher'
			];

			$teacher2 = [
				'first_name' => 'Иван',
				'last_name' => 'Григоревич',
				'name' => 'Григоревич Иван',
				'email' => 'g28i02v55@mail.ru',
				'password' => Hash::make('123456'),
				'role' => 'teacher'
			];
			
			$student = [
				'first_name' => 'test',
				'last_name' => 'test',
				'name' => 'test test',
				'email' => 'test@test.test',
				'password' => Hash::make('123456'),
				'role' => 'student'
			];

			User::create($admin1);
			User::create($admin2);
			User::create($teacher1);
			User::create($teacher2);
			User::create($student);

			// User::create($admin1)->profileStaff()->create([]);
			// User::create($admin2)->profileStaff()->create([]);

			// User::create($teacher1)->profileStaff()->create([]);
			// User::create($teacher2)->profileStaff()->create([]);
			
			// User::create($student)->profileStudent()->create([]);

			/*factory(App\User::class, 200)->create()->each(function ($u) {
				if ($u['role'] == 'student') {
					$u->profileStudent()->save(factory(App\ProfileStudent::class)->make());
				}
				else
          			$u->profileStaff()->save(factory(App\ProfileStaff::class)->make());
          
				$u->files()->save(factory(App\File::class)->make());
			});*/
    }
}
