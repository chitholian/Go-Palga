<?php

namespace App;

use App\Http\Controllers\Admin\IconController;
use Illuminate\Database\Eloquent\Model;

class File extends Model{
	protected $fillable = [
		'folder_id',
		'title',
		'index',
		'path',
		'slug',
		'size',
		'type',
		'tags',
		'description',
		'extension',
		'thumb_id'
	];

	public static function nextIndex($parent = 0){
		return File::where('folder_id', '=', $parent)->count('id') + 1;
	}

	public function mirrors(){
		return $this->hasMany('App\Mirror');
	}

	public function thumb(){
		return $this->belongsTo('App\Thumb');
	}

	public function folder(){
		return $this->belongsTo('App\Folder');
	}

	public function friendlySize(){
		return IconController::humanFileSize($this->size);
	}

	public function str_downloads(){
		return $this->downloads . " download" . ($this->downloads > 1 ? 's' : '');
	}
}
