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
use App\User; 

Route::get('/', 'WelcomeController@statistics');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->name('list')->middleware('admin','auth');

Route::patch('/users/{user}/promote', 'UserController@promote')->name('user_promote')->middleware('admin','auth', 'canChange');

Route::patch('/users/{user}/demote', 'UserController@demote')->name('user_demote')->middleware('admin','auth', 'canChange');

Route::patch('/users/{user}/block', 'UserController@block')->name('user_block')->middleware('admin','auth', 'canChange');

Route::patch('/users/{user}/unblock', 'UserController@unblock')->name('user_unblock')->middleware('admin','auth', 'canChange');

