<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mirror;

class MirrorController extends Controller{
	public static function addForm($parent){
		if($parent == 0){
			abort(403);
		}
		$title  = 'Add Mirror';
		$action = asset('backend/add/mirror');
		$mirror = new Mirror([
			'file_id' => $parent,
			'icon_id' => 1
		]);

		return view('admin.mirror_form', compact('title', 'action', 'mirror'));
	}

	public static function add(Request $request){
		$mirror = new Mirror($request->all());
		$mirror->save();
		redirect(asset('backend/file/' . $mirror->file_id))->send();
	}

	public static function editForm($id){
		$mirror = Mirror::find($id);
		if($mirror == null){
			abort(404);
		}
		$action = asset('backend/edit/mirror');
		$title  = 'Edit - ' . $mirror->title;

		return view('admin.mirror_form', compact('title', 'action', 'mirror'));
	}

	public static function edit(Request $request){
		$mirror = Mirror::find($request->input('mid', 0));
		if($mirror == null){
			abort(404);
		}
		$mirror->update($request->all());
		redirect(asset('backend/file/' . $mirror->file_id))->send();
	}

	public static function delete($id){
		$mirror  = Mirror::find($id);
		$mirror->delete();
		redirect(asset('backend/folder/'.$mirror->folder_id));
	}

	public static function showAdmin($id){
		$mirror = Mirror::find($id);
		if($mirror == null){
			abort(404);
		}

		return view('admin.mirror', compact('mirror'));
	}
}
