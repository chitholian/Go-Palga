<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{
	protected $fillable = [
		'folder_id',
		'index',
		'body'
	];

	public function folder(){
		return $this->belongsTo('App\Folder');
	}

	public static function nextIndex($parent = 0){
		return Message::where('folder_id', '=', $parent)->count('id') + 1;
	}

	public function viewCount(){
		return 'View' . ($this->views > 1 ? 's' : '') . ': ' . $this->views;
	}
}
