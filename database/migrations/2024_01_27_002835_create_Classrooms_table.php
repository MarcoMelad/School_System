<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassroomsTable extends Migration {

	public function up()
	{
		Schema::create('Classrooms', function(Blueprint $table) {
            $table->id();
            $table->string('Name_Class');
            $table->unsignedBigInteger('Grade_id');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('Classrooms');
//        Schema::table('Classrooms', function (Blueprint $table) {
//            $table->dropForeign('Classrooms_Grade_id_foreign');
//            $table->dropColumn('user_id');
//        });

    }
}
