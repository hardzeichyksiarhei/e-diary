<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('faculty_id')->unsigned()->nullable();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('health_group_id')->unsigned()->nullable();
            $table->string('birthday')->default('');
            $table->enum('gender', ['man', 'woman'])->nullable();
            $table->integer('course')->nullable();
            $table->string('group')->default('');
            $table->text('disease')->nullable();
            $table->timestamps();
        });

	    Schema::table('profile_students', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
		    $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
		    $table->foreign('health_group_id')->references('id')->on('health_groups')->onDelete('set null');

		    $table->index(['user_id', 'faculty_id', 'health_group_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_students');
    }
}
