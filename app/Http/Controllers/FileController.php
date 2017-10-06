<?php

namespace App\Http\Controllers;

use App\File;
use App\Mirror;
use Illuminate\Support\Facades\Storage;
use App\Category;
class FileController extends Controller{
	public static function index(){
		$categories = Category::where('type', '=', 'F')->get();
		return view('file_index', compact('categories'));
	}

	public static function updates(){
		return File::orderBy('created_at', 'desc')->take(10)->get();
	}

	public static function downloads(){
		return File::orderBy('downloads', 'desc')->take(10)->get();
	}

	public static function display($slug){
		$file = File::where('slug', '=', $slug)->first();
		if( ! $file){
			abort(404);
		}

		return view('file', compact('file'));
	}

	public static function download($slug){
		$file = File::where('slug', '=', $slug)->first();
		if( ! $file){
			abort(404);
		}
		$file->increment('downloads');
		set_time_limit(0);

		return response()->download(Storage::disk('upload')->path($file->path), $file->slug, ['Content-Type' => $file->type]);
	}

	public static function openMirror($id){
		$mirror = Mirror::find($id);
		if($mirror == null){
			abort(404);
		}
		$mirror->file->increment('downloads');
		redirect($mirror->url)->send();
	}
}
