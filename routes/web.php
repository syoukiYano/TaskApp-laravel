<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware'=>'auth'],function(){

Route::get('/', 'FolderController@index')->name('home');
Route::get('/folders/{id}/tasks','TaskController@index')->name('tasks.index');
Route::post('/folders/create','FolderController@create')->name('folders.create');
Route::post('/folders/{id}/tasks/create','TaskController@create')->name('tasks.create');
Route::post('/folders/{id}/tasks/{tasks_id}/edit','TaskController@edit')->name('tasks.edit');
Route::post('/folders/{id}/tasks/{tasks_id}/delete','TaskController@delete')->name('tasks.delete');
});
Auth::routes();
