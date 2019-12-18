<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionalStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functional_states', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();

          $table->tinyInteger('semester')->default(0);

          // 1
          $table->integer('length_body')->nullable();
          $table->integer('mass_body')->nullable();
          $table->double('mass_index_value', 5, 2)->nullable();
          $table->integer('mass_index_point')->default(0);

          // 2
          $table->integer('chss_lie')->nullable(); // ЧСС в положении лежа за 1 минууту
          $table->integer('chss_stand')->nullable(); // ЧСС в положении стоя за 1 минууту
          $table->integer('orthostatic_test_value')->nullable();
          $table->integer('orthostatic_test_point')->default(0);

          // 3
          $table->integer('chss_initial')->nullable(); // ЧСС исходная уд/10 сек
          $table->integer('chss_after_load')->nullable(); // ЧСС после нагрузки уд/сек
          $table->integer('chss_restoring')->nullable(); // ЧСС восстановления уд/сек
          $table->double('dosed_load_value', 5, 2)->nullable();
          $table->integer('dosed_load_point')->default(0);

          // 4
          $table->integer('sample_shtange')->nullable(); // Проба Штанге
          $table->integer('sample_shtange_point')->default(0);

          // 5
          $table->integer('sample_genchi')->nullable(); // Проба Штанге
          $table->integer('sample_genchi_point')->default(0);

          // ...
          $table->integer('count_tests')->default(0); // Число заполненых тестов
          $table->integer('sum_scores')->default(0); // Сумма баллов ФР и ФС
          $table->integer('assessment')->default(0); // Оценка ФР и ФС
          $table->string('level')->default(''); // Уровень ФР и ФС

          $table->timestamps();

          $table
            ->foreign('user_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('functional_states');
    }
}
