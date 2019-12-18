<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_statuses', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('user_id')->unsigned();
	        $table->integer('message_id')->unsigned();
					$table->enum('folder', ['inbox', 'sent']);
					$table->enum('status', ['active', 'trash']);
					$table->boolean('is_read')->default(0);
					$table->boolean('is_starred')->default(0);
          $table->timestamps();
          
          $table
            ->foreign('user_id')
            ->references('id')
            ->on('users');

          $table
            ->foreign('message_id')
            ->references('id')
            ->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_statuses');
    }
}
