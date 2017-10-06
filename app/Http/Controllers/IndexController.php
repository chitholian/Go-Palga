<?php

namespace App\Http\Controllers;


use App\Category;
use App\File;
use App\Folder;
use App\Message;

class IndexController extends Controller{
	public static function index(){
		$updates         = FileController::updates();
		$downloads       = FileController::downloads();
		$file_categories = Category::where([['type', '=', 'F'], ['folder_id','=',0]])->get();
		$sms_categories  = Category::where([['type', '=', 'S'], ['folder_id','=',0]])->get();

		return view('index', compact('updates', 'downloads', 'file_categories', 'sms_categories'));
	}

	public static function showContents($slug, $page = 1){
		$folder = Folder::where('slug', '=', $slug)->first();
		if( ! $folder){
			abort(404);
		}

		$files    = $folder->files->sortByDesc('index')->forPage($page, 15)->all();
		$messages = $folder->messages->sortByDesc('index')->forPage($page, 15)->all();
		$total_page = (int) ceil(max($folder->files->count(), $folder->messages->count()) / 15);

		return view('folder', compact('folder', 'messages', 'files', 'total_page', 'page'));
	}
}
