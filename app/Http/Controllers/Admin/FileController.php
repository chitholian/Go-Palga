<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller{
	/* MP3 Tags */
	public static $mp3_tags = array(
		'album'     => 'Edit this',
		'artist'    => 'Edit this',
		'publisher' => 'Edit this',
		'genre'     => 'Edit this',
		'composer'  => 'Edit this',
		'comment'   => 'Edit this',
	);

	/* End MP3 Tags */

	public static function addForm($parent){
		if($parent == 0){
			abort(403);
		}
		$title  = 'Add File';
		$action = asset('backend/add/file');
		$file   = new File([
			'index'     => File::nextIndex($parent),
			'folder_id' => $parent,
			'thumb_id'  => 1
		]);

		return view('admin.file_form', compact('title', 'action', 'file'));
	}

	private static function generateSlug($title, $ext, $id = - 1){
		$slug = $title = str_slug($title) . '.' . $ext;
		$ok   = false;
		$i    = 1;
		while( ! $ok){
			$ok = File::where([['slug', '=', $slug], ['id', '!=', $id]])->count() == 0;
			if( ! $ok){
				$slug = $i ++ . '-' . $title;
			}
		}

		return $slug;
	}

	public static function add(Request $request){
		$file = new File($request->all());
		if($request->input('url')){
			set_time_limit(0);
			$file->extension = pathinfo($request->input('url'), PATHINFO_EXTENSION);
			$curl            = curl_init();
			curl_setopt($curl, CURLOPT_URL, $request->input('url'));
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 16);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			if(curl_exec($curl)){
				$file->type = curl_getinfo($curl)['content_type'];
			}else{
				die("<h1 style='text-align: center'>HTTP Code " . curl_getinfo($curl)['http_code'] . "</h1> Sorry! Cannot download the file from <em>" . $request->input('url') . "</em>");
			}
			curl_close($curl);
			$file->path  = date('Y/m/') . time() . str_random() . '.' . $file->extension;
			$upload_path = Storage::disk('upload')->path($file->path);
			if( ! self::download($request->input('url'), $upload_path)){
				die("Oops!! Something went wrong to download the file from <em>" . $request->input('url') . "</em>");
			}
		}else if($request->hasFile('file') && $request->file('file')->isValid()){
			$file->extension = $request->file('file')->getClientOriginalExtension();
			$file->type      = $request->file('file')->getClientMimeType();
			$file->path      = Storage::disk('upload')->putFileAs(date('Y/m'), $request->file('file'), time().str_random().'.'.$file->extension);
		}
		if($file->path){
			$file->size = Storage::disk('upload')->size($file->path);
		}
		$file->slug = self::generateSlug($file->title, $file->extension);
		$file->save();
		if( ! $file->path){
			redirect(asset('backend/file/' . $file->id . '/edit'))->send();

			return;
		}
		TagController::writeTags($file, self::$mp3_tags);
		redirect(asset('backend/folder/' . $file->folder->category->type . '/' . $file->folder_id))->send();
	}

	public static function modifyForm($id){
		$file = File::find($id);
		if( ! $file){
			abort(404);
		}

		return view('admin.modify', compact('file'));
	}

	public static function modify(Request $request){
		$file = File::find($request->input('fid'));
		if( ! $file){
			abort(404);
		}
		$slug = self::generateSlug($file->title, $request->input('extension'));
		$file->update($request->all() + ['slug' => $slug]);
		redirect(asset('backend/folder/' . $file->folder->category->type . '/' . $file->folder_id))->send();

	}

	public static function editForm($id){
		$file = File::find($id);
		if($file == null){
			abort(404);
		}
		$action = asset('backend/edit/file');
		$title  = 'Edit - ' . $file->title;

		return view('admin.file_form', compact('title', 'action', 'file'));
	}

	public static function edit(Request $request){
		$file = File::find($request->input('fid', 0));
		if($file == null){
			abort(404);
		}
		$attributes = $request->all();
		if($attributes['folder_id'] == 0){
			abort(403);
		}
		$attributes['slug'] = self::generateSlug($attributes['title'], $file->extension, $file->id);
		$file->update($attributes);
		redirect(asset('backend/file/' . $file->id))->send();
	}

	public static function delete($id){
		$file = File::find($id);
		Storage::disk('upload')->delete($file->path);
		$file->delete();
		redirect(asset('backend/folder/F/' . $file->folder_id));
	}

	public static function showAdmin($id){
		$file = File::find($id);
		if($file == null){
			abort(404);
		}

		return view('admin.file', compact('file'));
	}

	/* Custom URL download */
	public static function download($file_source, $file_target){
		$rh = fopen($file_source, 'rb');
		$wh = fopen($file_target, 'w+b');
		if( ! $rh || ! $wh){
			return false;
		}
		while( ! feof($rh)){
			if(fwrite($wh, fread($rh, 4096)) === false){
				return false;
			}
			flush();
		}
		fclose($rh);
		fclose($wh);

		return true;
	}
}
