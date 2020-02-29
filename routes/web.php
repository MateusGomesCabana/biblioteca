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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/livros', ['uses'=>'api\BookController@index', 'as'=>'book.index']);
Route::get('/livros/add', ['uses'=>'api\BookController@add', 'as'=>'book.add']);
Route::get('/livros/edit', ['uses'=>'api\BookController@edit', 'as'=>'book.edit']);