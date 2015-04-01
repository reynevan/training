<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model {

  public function __construct(){
    $this->finished = false;
  }

	public function user(){
    return $this->belongsTo('App\User');
  }

  public function series(){
    return $this->hasMany('App\Serie');
  }

  public function scopeUnfinished($query){
    return $query->where('finished', false);
  }
}
