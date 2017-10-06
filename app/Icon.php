<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model{
	protected $fillable = ['path'];
	public $timestamps = false;

	public function folders(){
		return $this->hasMany('App\Folder');
	}

	public function mirror(){
		return $this->hasMany('App\Mirror');
	}
}
