<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieExercise extends Model {

	public function exercise(){
    return App\Exercise::find($this->exercise_id);
  }

  public function serie(){
    return $this->hasOne('App\Serie');
  }

}
