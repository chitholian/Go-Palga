<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller{
	public static function addForm($parent){
		if($parent == 0){
			abort(403);
		}
		$title   = 'Add SMS';
		$action  = asset('backend/add/sms');
		$message = new Message([
			'index'     => Message::nextIndex($parent),
			'folder_id' => $parent,
		]);

		return view('admin.message_form', compact('title', 'action', 'message'));
	}

	public static function add(Request $request){
		$message       = new Message($request->all());
		$message->save();
		redirect(asset('backend/folder/' . $message->folder->category->type . '/' . $message->folder_id))->send();
	}

	public static function editForm($id){
		$message = Message::find($id);
		if($message == null){
			abort(404);
		}
		$action = asset('backend/edit/sms');
		$title  = 'Edit - ' . $message->title;

		return view('admin.message_form', compact('title', 'action', 'message'));
	}

	public static function edit(Request $request){
		$message = Message::find($request->input('mid', 0));
		if($message == null){
			abort(404);
		}
		$message->update($request->all());
		redirect(asset('backend/folder/S/' . $message->folder_id))->send();
	}

	public static function delete($id){
		$sms = Message::find($id);
		$sms->delete();
		redirect(asset('backend/folder/S/' . $sms->folder_id));
	}

	public static function showAdmin($id){
		$sms = Message::find($id);
		if($sms == null){
			abort(404);
		}

		return view('admin.sms', compact('sms'));
	}
}
