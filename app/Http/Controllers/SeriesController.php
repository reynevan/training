<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Training;
use App\Serie;

use Auth;

class SeriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		$saved = true;
		$num = $request->input('seriesNum');
		$training = Auth::user()->trainings()->find($request->input('training_id'));
		$seriesCount = count($training->series()->get());
		$seriesIds = [];
		if ($seriesCount < $num){
			for ($i = $seriesCount+1; $i <= $num; $i++){
				$serie = new Serie();
				$serie->serie_number = $i;
				if (!$training->series()->save($serie))
					$saved = false;
			}
		}
		if ($request->input('ajax'))
			return $saved ? 'saved' : 'error';
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
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
