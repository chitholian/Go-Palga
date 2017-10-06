<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Thumb;
use Illuminate\Support\Facades\Storage;

class ThumbController extends Controller{
	public static function getThumbs(){
		return Thumb::all();
	}

	public static function showThumbs(){
		$thumbs = Thumb::all();

		return view('admin.thumbs', compact('thumbs'));
	}

	public static function upload(Request $request){
		if($request->hasFile('thumb') && $request->file('thumb')->isValid()){
			$file = new Thumb(['path' => Storage::disk('public')->putFileAs('thumbs', $request->file('thumb'), 'th-' . time(). '.png')]);
			$file->save();
		}
		back()->send();
	}

}
