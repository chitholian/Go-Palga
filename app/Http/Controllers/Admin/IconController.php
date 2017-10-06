<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Icon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IconController extends Controller{
	public static function getIcons(){
		return Icon::all();
	}

	public static function showIcons(){
		$icons = Icon::all();

		return view('admin.icons', compact('icons'));
	}

	public static function upload(Request $request){
		if($request->hasFile('icon') && $request->file('icon')->isValid()){
			$file = new Icon(['path' => Storage::disk('public')->putFileAs('ico', $request->file('icon'), 'ic-' . time(). '.png')]);
			$file->save();
		}
		back()->send();
	}

	public static function generateSlug($table, $title, $id = - 1){
		$slug = $title = str_slug($title);
		$ok   = false;
		$i    = 1;
		while( ! $ok){
			$ok = DB::table($table)->where([['slug', '=', $slug], ['id', '!=', $id]])->count() == 0;
			if( ! $ok){
				$slug = $i ++ . '-' . $title;
			}
		}

		return $slug;
	}

	public static function humanFileSize($size, $unit = ""){
		if(( ! $unit && $size >= 1 << 30) || $unit == " GB"){
			return number_format($size / (1 << 30), 2) . " GB";
		}
		if(( ! $unit && $size >= 1 << 20) || $unit == " MB"){
			return number_format($size / (1 << 20), 2) . " MB";
		}
		if(( ! $unit && $size >= 1 << 10) || $unit == " KB"){
			return number_format($size / (1 << 10), 2) . " KB";
		}

		return number_format($size) . " bytes";
	}
}
