<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller{
	public static function addForm($type = 'F', $parent = 0){
		$title    = 'Add category';
		$action   = asset('backend/add/category');
		$category = new Category([
			'index'     => Category::nextIndex($parent),
			'folder_id' => $parent,
			'type'      => $type
		]);

		return view('admin.category_form', compact('title', 'action', 'category'));
	}

	public static function add(Request $request){
		$category = new Category($request->all());
		$category->save();
		redirect(asset('backend/folder/' . $category->type . '/' . $category->folder_id))->send();
	}

	public static function editForm($id){
		$category = Category::find($id);
		if($category == null) abort(404);
		$action   = asset('backend/edit/category');
		$title    = 'Edit - ' . $category->title;

		return view('admin.category_form', compact('title', 'action', 'category'));
	}

	public static function edit(Request $request){
		$category = Category::find($request->input('cid', 0));
		if($category == null) abort(404);
		$category->update($request->all());
		redirect(asset('backend/folder/' . $category->type . '/' . $category->folder_id))->send();
	}
}
