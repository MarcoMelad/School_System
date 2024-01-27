<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassroomsTable extends Migration {

	public function up()
	{
		Schema::create('Classrooms', function(Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->integer('Grade_id')->unsigned();
			$table->string('Name_Class');
		});
	}

	public function down()
	{
		Schema::drop('Classrooms');
	}
}
