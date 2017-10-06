<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Folder;
use App\Message;
use App\File;
use App\Http\Controllers\Controller;

class IndexController extends Controller{

	public static function adminFolder($type = 'F', $id = 0){
		if($id == 0){
			$folder          = new Folder(['id' => 0]);
			$folder->icon_id = 1;
		}else{
			$folder = Folder::find($id);
		}

		if($folder == null){
			abort(404);
		}
		$files      = File::where('folder_id', '=', $id)->orderBy('index')->get();
		$messages   = Message::where('folder_id', '=', $id)->orderBy('index')->get();
		$categories = Category::where([['folder_id', '=', $id], ['type', '=', $type]])->orderBy('index')->get();
		if($type == 'F'){
			return view('admin.file_folder', compact('categories', 'folder', 'messages', 'files'));
		}else{
			return view('admin.sms_folder', compact('categories', 'folder', 'messages', 'files'));
		}
	}
}
