<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mirror extends Model{
	protected $fillable = [
		'file_id',
		'title',
		'url',
		'icon_id',
	];

	public $timestamps = false;

	public function file(){
		return $this->belongsTo('App\File');
	}

	public function icon(){
		return $this->belongsTo('App\Icon');
	}
}
