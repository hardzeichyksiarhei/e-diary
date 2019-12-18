<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
          $table->increments('id');
					$table->integer('sender_id')->unsigned();
					$table->string('subject');
					$table->string('excerpt');
	        $table->text('message');
					$table->timestamps();
					
					$table
		        ->foreign('sender_id')
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
        Schema::dropIfExists('messages');
    }
}