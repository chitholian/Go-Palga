<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model{
	protected $fillable = [
		'id',
		'category_id',
		'title',
		'index',
		'slug',
		'tags',
		'description',
		'icon_id'
	];
	public $timestamps = false;

	public static function nextIndex($parent){
		return Folder::where('category_id', '=', $parent)->count('id') + 1;
	}

	public function categories(){
		return $this->hasMany('App\Category')->orderBy('index');
	}

	public function category(){
		return $this->belongsTo('App\Category');
	}

	public function icon(){
		return $this->belongsTo('App\Icon');
	}
	public function files(){
		return $this->hasMany('App\File')->orderBy('index');
	}

	public function messages(){
		return $this->hasMany('App\Message')->orderBy('index');
	}
}
