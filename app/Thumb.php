<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumb extends Model{
	public $timestamps = false;
	protected $fillable = ['path'];

	public function file(){
		return $this->hasMany('App\File');
	}
}
