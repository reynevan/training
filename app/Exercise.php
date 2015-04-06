<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model {

  protected $fillable = ['name'];

	public function user(){
    return $this->belongsTo('App\User');
  }
  public function serie(){
    return $this->belongsTo('App\Serie');
  }
  public function scopeAcitive($query){
    return $query->where('active', true);
  }

}
