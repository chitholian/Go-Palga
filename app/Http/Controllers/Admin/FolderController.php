<?php

namespace App\Http\Controllers\Admin;

use App\Folder;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
class FolderController extends Controller{
	public static function addForm($parent){
		if($parent == 0){
			abort(403);
		}
		$title  = 'Add folder';
		$action = asset('backend/add/folder');
		$folder = new Folder([
			'index'       => Folder::nextIndex($parent),
			'category_id' => $parent,
			'icon_id'     => 1
		]);

		return view('admin.folder_form', compact('title', 'action', 'folder'));
	}

	public static function add(Request $request){
		$folder       = new Folder($request->all());
		$folder->slug = IconController::generateSlug('folders', $folder->title);
		$folder->save();
		redirect(asset('backend/folder/' . $folder->category->type . '/' . $folder->category->folder_id))->send();
	}

	public static function editForm($id){
		$folder = Folder::find($id);
		if($folder == null){
			abort(404);
		}
		$action = asset('backend/edit/folder');
		$title  = 'Edit - ' . $folder->title;

		return view('admin.folder_form', compact('title', 'action', 'folder'));
	}

	public static function edit(Request $request){
		$folder = Folder::find($request->input('fid', 0));
		if($folder == null){
			abort(404);
		}
		$attributes         = $request->all();
		if($attributes['category_id'] == 0){
			abort(403);
		}
		$attributes['slug'] = IconController::generateSlug('folders', $attributes['title'], $attributes['fid']);
		$folder->update($attributes);
		redirect(asset('backend/folder/' . $folder->category->type . '/' . $folder->id))->send();
	}
}
