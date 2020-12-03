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

Route::get('/', function () {
    return view('welcome')
        ;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


######################################## Start categories Routes ########################################

Route::group(['prefix' => 'category'], function () {
    Route::get('', 'CategoryController@index')
        ->name('category.index')->middleware('auth');
    Route::get('/create', 'CategoryController@create')
        ->name('category.create')->middleware('auth');
    Route::post('', 'CategoryController@store')
        ->name('category.store')->middleware('auth');
    Route::get('/{id}', 'CategoryController@show')
        ->name('category.show')->middleware('auth');
    Route::get('/{id}/edit', 'CategoryController@edit')
        ->name("category.edit")->middleware('auth');
    Route::patch('/{id}', 'CategoryController@update')
        ->name('category.update')->middleware('auth');
    Route::delete('/{id}', 'CategoryController@destroy')
        ->name('category.destroy')->middleware('auth');
});
######################################### End categories Routes #########################################


######################################## Start transactions Routes ########################################

Route::group(['prefix' => 'transaction'], function () {
    Route::get('', 'TransactionController@index')
        ->name('transaction.index')->middleware('auth');
    Route::get('/create', 'TransactionController@create')
        ->name('transaction.create')->middleware('auth');
    Route::post('', 'TransactionController@store')
        ->name('transaction.store')->middleware('auth');
    Route::get('{type}/chart', 'TransactionController@chart')
        ->name('transaction.chart')->middleware('auth');

});
######################################### End transactions Routes #########################################

######################################## Start Admin Routes ########################################


Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
######################################### End transactions Routes #########################################
