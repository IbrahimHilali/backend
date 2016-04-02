<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

    // Authentication Routes...
    $this->get('login', 'Auth\AuthController@showLoginForm');
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', function () {
            return redirect('home');
        });

        Route::get('/home', 'HomeController@index');

        Route::resource('books', 'BooksController');
        Route::resource('persons', 'PersonsController');
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');

        Route::get('books/{book_id}/person/{person_id}', ['as' => 'books.person', 'uses' => 'BooksPersonController@show']);
        Route::get('persons/{person_id}/add-book', ['as' => 'persons.add-book', 'uses' => 'BooksPersonController@personAddBook']);
    });
});
