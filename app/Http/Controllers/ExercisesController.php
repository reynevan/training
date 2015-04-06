<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;

use App\Exercise;

use Jenssegers\Date\Date;

Date::setLocale('pl');

class ExercisesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$chartExercises = [];
		$exercises = Auth::user()->exercises;
		foreach ($exercises as $exKey=>$exercise){
			$maxRepeats = 0;
			$sumRepeats = 0;
			foreach (Auth::user()->trainings as $training){
				foreach ($training->series as $serie){
					if (count($serie->exercise($exercise->id)->first()))
						$repeats = $serie->exercise($exercise->id)->first()->repeats;
					else
						$repeats = 0;
					$sumRepeats += $repeats;
					if ($maxRepeats == 0 || $repeats > $maxRepeats)
						$maxRepeats = $repeats;
				}
			}
			$exercise->maxRepeats = $maxRepeats;
			$exercise->sumRepeats = $sumRepeats;
			if ($exercise->updated_at == $exercise->created_at)
				$exercise->lastMade = '-';
			else	
				$exercise->lastMade = Date::parse($exercise->updated_at)->diffForHumans();

			$chartExercises[$exercise->name] = [];	 
			foreach (Auth::user()->trainings()->get() as $trKey=>$training){
				$chartExercises[$exercise->name][$trKey] = [];
				$date = Date::parse($training->updated_at);
				$chartExercises[$exercise->name][$trKey]['date'] = ['year' => $date->format("Y"), 'month' => $date->format("m"), 'day' => $date->format("d"), 'hour' => $date->format("G"), 'minutes' => $date->format("i")];
				$chartExercises[$exercise->name][$trKey]['series'] = [];
				foreach ($training->series()->get() as $serKey=>$serie){
					foreach ($serie->exercises()->get() as $serExKey=>$serieExercise){
						if ($serieExercise->exercise()){
							if ($serieExercise->exercise()->id == $exercise->id)
								$chartExercises[$exercise->name][$trKey]['series'][$serie->serie_number] = $serieExercise->repeats;	
						}				
					}				
				}
			}
		}

		

		return view('exercises.index', compact('exercises', 'chartExercises'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$exercise = new Exercise();
		if (strlen($request->input('name')) < 3)
			return 'too short';
		$exercise->name = $request->input('name');
		Auth::user()->exercises()->save($exercise);

		if ($request->input('ajax'))
			return json_encode(['id' => $exercise->id, 'token' => csrf_token()]);
		else
			return redirect('exercises');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$exercise = Exercise::findOrFail($id);
		$owner = $exercise->user()->first();
		$trainings = [];
		foreach ($owner->trainings()->get() as $training){
			$trainings[$training->id] = [];
			$date = Date::parse($training->updated_at);
			$trainings[$training->id]['date'] = ['year' => $date->format("y"), 'month' => $date->format("m"), 'day' => $date->format("d")];
			$trainings[$training->id]['series'] = [];
			foreach ($training->series()->get() as $serie){
				foreach ($serie->exercises()->get() as $serieExercise){
					if ($serieExercise->exercise()->id == $id)
						$trainings[$training->id]['series'][$serie->serie_number] = $serieExercise->repeats;
					
				}
				
			}
		}
		return view('exercises.show', compact('trainings', 'exercise'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Request $request)
	{
		$myExc = false;
		foreach (Auth::user()->exercises()->get() as $exercise){
			if ($exercise->id == $id){
				$myExc = true;
				break;
			}
		}
		if ($request->input('ajax')){
			if ($myExc){
				if (Exercise::destroy($id))
					return '1';
				return '0';
			}
			return '0';
		}
		else if ($myExc)
			Exercise::destroy($id);
	}

}
