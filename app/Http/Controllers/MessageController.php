<?php

namespace App\Http\Controllers;

use App\Category;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller{
	public static function index(){
		$categories = Category::where('type', '=', 'S')->get();

		return view('sms_index', compact('categories'));
	}

	public static function display($id){
		$sms = Message::find($id);
		if( ! $sms){
			abort(404);
		}
		$sms->increment('views');
		return view('sms', compact('sms'));
	}
}
