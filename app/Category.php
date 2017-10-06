<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
	protected $fillable = ['folder_id', 'title', 'index', 'type'];

	public $timestamps = false;
	public function folders(){
		return $this->hasMany('App\Folder')->orderBy('index');
	}

	public function folder(){
		return $this->belongsTo('App\Folder');
	}

	public static function nextIndex($parent = 0){
		return Category::where('folder_id', '=', $parent)->count('id') + 1;
	}
}
