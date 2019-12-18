<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_attachments', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('message_id')->unsigned();
          $table->string('name');
          $table->string('type');
          $table->string('extension');

          $table->timestamps();

          $table
            ->foreign('message_id')
            ->references('id')
            ->on('messages')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_attachments');
    }
}
