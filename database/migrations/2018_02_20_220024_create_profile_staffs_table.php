<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_staffs', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('user_id')->unsigned();
					$table->string('birthday')->default('');
					$table->string('phone')->default('');
					$table->string('position')->default('');
					$table->string('rank')->default('');
					$table->string('degree')->default('');
					$table->text('description')->nullable();
					$table->timestamps();
        });

        Schema::table('profile_staffs', function($table) {
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
        Schema::dropIfExists('profile_staffs');
    }
}
