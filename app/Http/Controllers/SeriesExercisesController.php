<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\SerieExercise;
use App\Training;
use App\Exercise;
class SeriesExercisesController extends Controller {

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
    $training = Training::find($request->input('training_id'));
    foreach ( $training->series()->get() as $serie){
      for ($i = 1; $i < sizeOf($request->input('series')); $i++){
        if ($serie->serie_number == $i){
          $serieExc = new SerieExercise();
          $serieExc->exercise_id = $request->input('exercise_id');
          $serieExc->repeats = $request->input('series')[$i];
          $serieExc->serie_id = $serie->id;
          if (count($training->series()->find($serie->id)->exercises()->where('exercise_id', $serieExc->exercise_id)->get()) == 0){
            if (!$serieExc->save())
              $saved = false;
          }
          else{
            if (!SerieExercise::where(['serie_id'=> $serie->id, 'exercise_id' => $serieExc->exercise_id])->update(['repeats' => $serieExc->repeats]))
              $saved = false;
          }
          if ($saved)
            Exercise::findOrFail($serieExc->exercise_id)->touch();
        }
      }
    }
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
