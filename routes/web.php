<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// backend routes
Route::group(['prefix' => 'backend', 'middleware' => 'auth', 'namespace' => 'Admin'], function(){

	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/add/category/{type}/{parent}', 'CategoryController@addForm');
	Route::post('/add/category', 'CategoryController@add');
	Route::get('/edit/category/{id}', 'CategoryController@editForm');
	Route::post('/edit/category', 'CategoryController@edit');

	Route::get('/add/folder/{parent}', 'FolderController@addForm');
	Route::post('/add/folder', 'FolderController@add');
	Route::get('/edit/folder/{id}', 'FolderController@editForm');
	Route::post('/edit/folder', 'FolderController@edit');
	Route::get('/folder/{type}/{id}', 'IndexController@adminFolder');

	Route::get('/add/sms/{parent}', 'MessageController@addForm');
	Route::post('/add/sms', 'MessageController@add');
	Route::get('/edit/sms/{id}', 'MessageController@editForm');
	Route::post('/edit/sms', 'MessageController@edit');
	Route::get('/sms/{id}', 'MessageController@showAdmin');

	Route::get('/icons', 'IconController@showIcons');
	Route::post('/icons', 'IconController@upload');

	Route::get('/thumbs', 'ThumbController@showThumbs');
	Route::post('/thumbs', 'ThumbController@upload');

	Route::get('/add/file/{parent}', 'FileController@addForm');
	Route::post('/add/file', 'FileController@add');
	Route::get('/edit/file/{id}', 'FileController@editForm');
	Route::post('/edit/file', 'FileController@edit');
	Route::get('/file/{id}', 'FileController@showAdmin');
	Route::get('/file/{id}/edit', 'FileController@modifyForm');
	Route::post('/file/{id}/edit', 'FileController@modify');

	Route::get('/add/mirror/{parent}', 'MirrorController@addForm');
	Route::post('/add/mirror', 'MirrorController@add');
	Route::get('/edit/mirror/{id}', 'MirrorController@editForm');
	Route::post('/edit/mirror', 'MirrorController@edit');
	Route::get('/mirror/{id}', 'MirrorController@showAdmin');

	Route::delete('/mirror/{id}', 'MirrorController@delete');
	Route::delete('/sms/{id}', 'MessageController@delete');
	Route::delete('/file/{id}', 'FileController@delete');
});

Route::any('/backend/delete/public/{id}', 'PublicFileController@delete')->middleware('auth');

// frontend routes
Route::any('/', 'IndexController@index');

Route::any('/file/{slug}', 'FileController@display');
Route::any('/file/download/{slug}', 'FileController@download');

Route::any('/open-mirror/{id}', 'FileController@openMirror');


Route::any('/sms', 'MessageController@index');
Route::any('/sms/{slug}', 'MessageController@display');

Route::any('/downloads', 'FileController@index');

Route::get('/public-uploads/{page?}', 'PublicFileController@index')->name('public_index');
Route::post('/public-uploads/{page?}', 'PublicFileController@upload');
Route::any('/public-uploads/download-file-by-id/{id}', 'PublicFileController@download');


Route::any('/{slug}', 'IndexController@showContents');
Route::any('/{slug}/page/{page}', 'IndexController@showContents');
