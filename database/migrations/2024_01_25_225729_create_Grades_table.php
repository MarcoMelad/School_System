<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGradesTable extends Migration {

	public function up()
	{
		Schema::create('Grades', function(Blueprint $table) {
			$table->id();
			$table->string('Name')->unique();
			$table->string('Notes')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('Grades');
	}
}
