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

//Cadastro de livros
Route::get('/livros', ['uses'=>'api\BookController@index', 'as'=>'book.index']);
Route::post('/livros/save', ['uses'=>'api\BookController@save', 'as'=>'book.save']);
Route::get('/livros/add', ['uses'=>'api\BookController@add', 'as'=>'book.add']);
Route::get('/livros/edit/{id}', ['uses'=>'api\BookController@edit', 'as'=>'book.edit']);
Route::post('/livros/update/{id}', ['uses'=>'api\BookController@update', 'as'=>'book.update']);
Route::get('/livros/delete/{id}', ['uses'=>'api\BookController@delete', 'as'=>'book.delete']);
Route::put('/livros/search', ['uses'=>'api\BookController@search', 'as'=>'book.search']);
//aluguel de livros
Route::get('/loan', ['uses'=>'api\LoanController@index', 'as'=>'loan.index']);
Route::get('/loan/add', ['uses'=>'api\LoanController@add', 'as'=>'loan.add']);
Route::get('/loan/save/{id}', ['uses'=>'api\LoanController@save', 'as'=>'loan.save']);
Route::get('/loan/edit', ['uses'=>'api\LoanController@edit', 'as'=>'loan.edit']);
Route::get('/loan/update/{id}', ['uses'=>'api\LoanController@update', 'as'=>'loan.update']);
Route::get('/loan/delete/{id}', ['uses'=>'api\LoanController@delete', 'as'=>'loan.delete']);
Route::put('/loan/search', ['uses'=>'api\LoanController@search', 'as'=>'loan.search']);