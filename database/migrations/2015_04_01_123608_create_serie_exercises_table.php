<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerieExercisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('serie_exercises', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('serie_id');
			$table->integer('exercise_id');
			$table->integer('repeats');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('serie_exercises');
	}

}
