<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model {

  protected $fillable = ['training_id', 'serie_number'];

  public function training(){
    return $this->belongsTo('App\Training');
  }

  public function exercises(){
    return $this->hasMany('App\SerieExercise');
  }

  public function exercise($id){
    return $this->exercises()->where('exercise_id', $id);
  }

  public function delete(){
    $this->exercises()->delete();

    return parent::delete();
  }
  
}
