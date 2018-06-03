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

//US1
Route::get('/', 'WelcomeController@statistics');

//US2,3,4
Auth::routes();

//US5
Route::get('/users', 'UserController@index')->name('admin_list');

//US7
Route::patch('/users/{user}/promote', 'UserController@promote')->name('user_promote');
Route::patch('/users/{user}/demote', 'UserController@demote')->name('user_demote');
Route::patch('/users/{user}/block', 'UserController@block')->name('user_block');
Route::patch('/users/{user}/unblock', 'UserController@unblock')->name('user_unblock');

//US8
Route::get('/home', 'HomeController@index')->name('home');

//US9
Route::get('/me/password', 'PasswordController@index')->name('show_changePass');
Route::patch('/me/password', 'PasswordController@changePassword')->name('change_pass');

//US10
Route::get('/me/profile', 'ProfileController@index')->name('show_changeProfile');
Route::put('/me/profile', 'ProfileController@changeProfile')->name('change_profile');

//US11
Route::get('/profiles', 'UserController@getProfiles')->name('profile_list');

//US12
Route::get('/me/associates', 'UserController@getAssociates')->name('associates');

//US13
Route::get('/me/associate-of', 'UserController@getAssociateOf')->name('associateOf');

//US14
Route::get('/accounts/{user}', 'AccountController@list')->name('accounts_list');
Route::get('/accounts/{user}/opened', 'AccountController@opened')->name('openedAccounts_list');
Route::get('/accounts/{user}/closed', 'AccountController@closed')->name('closedAccounts_list');

//US15
Route::delete('/accounts/{account}', 'AccountController@destroy')->name('account_delete');
Route::patch('/accounts/{account}/close', 'AccountController@close')->name('account_close');













