<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$user = App\User::create(['name' => 'pafeu', 'email'=>'pafeu@example.com', 'password'=>bcrypt('dupa123')]);

		$ex1 = App\Exercise::create(['name' => 'pompki', 'user_id' => 1]);
		$ex2 = App\Exercise::create(['name' => 'pszysiady', 'user_id' => 1]);

		// $tr1 = App\Training::create(['user_id' => 1]);

		// $serie1 = new App\Serie();
		// $tr1->series()->save($serie1);

		// $serie2 = new App\Serie();
		// $tr1->series()->save($serie2);

		// $sxc1 = new App\SerieExercise();
		// $sxc1->exercise_id = $ex1->id;
		// $sxc1->repeats = 10;
		// $serie1->exercises()->save($sxc1);

		// $sxc2 = new App\SerieExercise();
		// $sxc2->exercise_id = $ex2->id;
		// $sxc2->repeats = 15;
		// $serie1->exercises()->save($sxc2);

		// $sxc3 = new App\SerieExercise();
		// $sxc3->exercise_id = $ex1->id;
		// $sxc3->repeats = 12;
		// $serie2->exercises()->save($sxc3);

		// $sxc4 = new App\SerieExercise();
		// $sxc4->exercise_id = $ex2->id;
		// $sxc4->repeats = 17;
		// $serie2->exercises()->save($sxc4);

		// *******************************

		// $tr2 = App\Training::create(['user_id' => 1]);

		// $serie3 = new App\Serie();
		// $tr2->series()->save($serie3);

		// $serie4 = new App\Serie();
		// $tr2->series()->save($serie4);

		// $sxc1 = new App\SerieExercise();
		// $sxc1->exercise_id = $ex1->id;
		// $sxc1->repeats = 13;
		// $serie3->exercises()->save($sxc1);

		// $sxc2 = new App\SerieExercise();
		// $sxc2->exercise_id = $ex2->id;
		// $sxc2->repeats = 18;
		// $serie3->exercises()->save($sxc2);

		// $sxc3 = new App\SerieExercise();
		// $sxc3->exercise_id = $ex1->id;
		// $sxc3->repeats = 14;
		// $serie4->exercises()->save($sxc3);

		// $sxc4 = new App\SerieExercise();
		// $sxc4->exercise_id = $ex2->id;
		// $sxc4->repeats = 19;
		// $serie4->exercises()->save($sxc4);

	}

}
