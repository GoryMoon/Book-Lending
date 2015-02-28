<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController2@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/


Route::get('/', array('as' => 'home', function()
{
    //Should not really be here, should be in a controller. This was a quick fix
    $breaks = array("<br />","<br>","<br/>"); 
    $books = App\Models\Book::with('authors', 'categories')->get();

    foreach ($books as $value) {
        $value->description = str_ireplace($breaks, "<br>", $value->description);
        $value->genres = implode('<br>', reformatValues($value->categories->toArray(), true));
        $value->author = implode("; ", reformatValues($value->authors->toArray(), true));

        $url = $value->imageUrl;
        if (!str_contains($url, 'no_book_cover.jpg') && !str_contains($url, 'http')) {
            $url = '/storage/' . $url; 
        } elseif (!str_contains($url, 'http')) {
            $url = '/images/no_book_cover.jpg';
        }
        $value->image = Illuminate\Html\HtmlFacade::image($url, null, array('style' => 'height:300px'));
    }
    return View::make('index')->with('books', $books);
}));

Route::controller('password', 'RemindersController');

Route::get('logout', array('as' => 'logout', 'middleware' => 'auth', 'uses' => 'SessionController@destroy'));
Route::resource('sessions', 'SessionController', array('only' => array('store', 'destroy')));
Route::resource('books', 'BooksController', array('only' => array('show')));

Route::group(array('before' => array('admin'), 'prefix' => 'admin'), function()
{
    Route::get('/', array('as' => 'admin', function()
    {
        return View::make('admin');
    }));

    Route::resource('users', 'UsersController');
    Route::resource('books', 'BooksController');
});

// Should not be here, was for a quick fix
function reformatValues($cat, $nameOnly = false)
{
    $result = array();
    foreach ($cat as $val) {
        if ($nameOnly) {
            $result[] = $val['name'];
        } else {
            $result[] = $val['id'];
        }
    }
    return $result;
}
