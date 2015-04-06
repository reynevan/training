<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model {

  public function __construct(){
    $this->finished = false;
  }

  protected $fillable = ['finished'];

	public function user(){
    return $this->belongsTo('App\User');
  }

  public function series(){
    return $this->hasMany('App\Serie');
  }

  public function scopeUnfinished($query){
    return $query->where('finished', false);
  }

  public function scopeFinished($query){
    return $query->where('finished', true);
  }
  public function exercises(){
    return $this->series->first()->exercises()->get();
  }

  public function delete(){
    $this->series()->delete();

    return parent::delete();
  }
}
