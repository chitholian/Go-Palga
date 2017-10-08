<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Folder;
use App\Http\Controllers\Controller;

class MyController extends Controller{
	public static function index(){
		return ('Stopped!');
		$folders = [
		];

		foreach($folders as $name){
			$folder = new Folder([
				'title'       => $name,
				'slug'        => IconController::generateSlug('folders', $name),
				'icon_id'     => 1,
				'category_id' => 5,
				'index'       => 1
			]);
			$folder->save();
			$category = new Category(['title' => 'Downloads', 'type' => 'F', 'index' => 1, 'folder_id' => $folder->id]);
			$category->save();
			echo "<br/> ".$name;
		}
	}
}
