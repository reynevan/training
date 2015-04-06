<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;

use App\Training; 

use Jenssegers\Date\Date;

use \Session;
Date::setLocale('pl');

class TrainingsController extends Controller {


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
		if (count(Auth::user()->exercises) == 0){
			Session::flash('alert', 'Dodaj najpierw jakies ćwiczenia do "swoich ćwiczeń"');
			return redirect('/exercises');
		}
		$trainingsFinished 	= Auth::user()->trainings()->finished()->orderBy('updated_at', 'desc')->paginate(5);
		$trainingUnfinished = Auth::user()->trainings()->unfinished()->orderBy('created_at', 'desc')->first();
		if (count($trainingUnfinished))
			$trainingUnfinished->started = Date::parse($trainingUnfinished->created_at)->diffForHumans();
		if (count($trainingsFinished)){
			foreach ($trainingsFinished as $training)
				$training->humanDate = Date::parse($training->updated_at)->diffForHumans();
				if (strlen($training->humanDate) == 0)
					$training->humanDate = 'xD';
		}
		$exercises = Auth::user()->exercises()->get();
		return view('trainings.index', compact(['trainingsFinished', 'trainingUnfinished', 'exercises']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$training = new Training();
		$training->user_id = Auth::user()->id;
		$training->save();

		if ($request->input('ajax'))
			return $training->id;
		else
			redirect('trainings');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
	public function update($id, Request $request)
	{
		if ($request->input('touch')){
			Auth::user()->trainings()->findOrFail($id)->touch();
			return 'saved';
		}
		else {
			$training = Auth::user()->trainings()->findOrFail($id);
			if ($training->update(['finished' => true]))
				return view('partials._finishedTraining', compact('training'));
			else
				return 'error';
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::user()->trainings()->findOrFail($id)->delete())
			return 'deleted';
		else
			return 'error';
	}

}
