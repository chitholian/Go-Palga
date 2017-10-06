<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FileController;
use App\PublicFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Storage;

class PublicFileController extends Controller{
	public static function index($page = 1){
		$files      = PublicFile::orderBy('id', 'desc')->forPage($page, 15)->get();
		$total_page = (int) ceil(PublicFile::count('id') / 15);
		if($page != 1 && $page > $total_page || $page < 1){
			abort(404);
		}

		return view('public', compact('files', 'page', 'total_page'));
	}

	public static function upload(Request $request, $page = 1){
		$file = new PublicFile(['title' => $request->input('title')]);
		if($request->input('title') && $request->hasFile('file') && $request->file('file')->isValid()){
			$file->type     = $request->file('file')->getClientMimeType();
			$file->path     = Storage::disk('upload')->putFileAs('public/' . date('Y/m'), $request->file('file'), time() . '.' . $request->file('file')->getClientOriginalExtension());
			$file->size     = Storage::disk('upload')->size($file->path);
			$file->thumb_id = 1;
			$file->save();
			TagController::writeTags($file, FileController::$mp3_tags);
		}else{
			abort(403);
		}

		return redirect(route('public_index', ['page' => $page]));
	}

	public static function download($id){
		$file = PublicFile::find($id);
		if( ! $file){
			abort(404);
		}
		$path = Storage::disk('upload')->path($file->path);

		return response()->download($path, filter_var($file->title, FILTER_SANITIZE_ENCODED). '.' . pathinfo($path, PATHINFO_EXTENSION));
	}

	public static function delete($id){
		$file = PublicFile::find($id);
		if(!$file) abort(404);
		$file->delete();
		return "Deletion Successful !";
	}
}
