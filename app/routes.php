<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', function()
{
    return View::make('index');
}));

Route::controller('password', 'RemindersController');

Route::get('logout', array('as' => 'logout', 'before' => 'auth', 'uses' => 'SessionController@destroy'));
Route::resource('sessions', 'SessionController', array('only' => array('store', 'destroy')));

Route::group(array('before' => 'admin', 'prefix' => 'admin'), function()
{
    Route::get('/', array('as' => 'admin', function()
    {
        return View::make('admin');
    }));

    Route::resource('users', 'UsersController', array('before' => 'csrf'));
    Route::resource('books', 'BooksController', array('before' => 'csrf'));
});
