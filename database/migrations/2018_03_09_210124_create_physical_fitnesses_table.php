<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhysicalFitnessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_fitnesses', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('user_id')->unsigned();

	        $table->tinyInteger('semester')->default(0);

					// Физиометрические
					$table->integer('long_jump')->nullable(); // Прыжок в длину с места (см)
					$table->integer('long_jump_point')->default(0);

					$table->integer('torso_inclination')->nullable(); // Наклон туловища вперед (см)
					$table->integer('torso_inclination_point')->default(0);

					$table->float('run_shuttle')->nullable(); // Челночный бег 4x9 метров (сек)
					$table->integer('run_shuttle_point')->default(0);

					$table->integer('pull_up')->nullable(); // Подтягивание на перекладине (кол-во раз)
					$table->integer('pull_up_point')->default(0);

					$table->integer('press')->nullable(); // Поднимание туловища из положения лежа на спине за 60 с, раз
					$table->integer('press_point')->default(0);

					$table->integer('push_up')->nullable(); // Сгибание и рахгибание рук в упоре лежа, раз
					$table->integer('push_up_point')->default(0);

					$table->double('run_short', 5, 2)->nullable(); // Бег 30 м (сек)
					$table->integer('run_short_point')->default(0);

					$table->double('run_long', 5, 2)->nullable(); // Бег 1500/3000 м (мин. сек)
					$table->integer('run_long_point')->default(0);

					$table->double('swimming_s', 5, 2)->nullable(); // плавание 50 (мин. сек)
					$table->integer('swimming_m')->nullable();
					$table->integer('swimming_point')->default(0);

          // ...
          $table->integer('count_tests')->default(0); // Число заполненых тестов
					$table->integer('sum_scores')->default(0); // Сумма баллов ФП
					$table->integer('assessment')->default(0); // Оценка ФП
					$table->string('level')->default(''); // Уровень ФП

          $table->timestamps();


          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_fitnesses');
    }
}
