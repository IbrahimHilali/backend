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

$this->group(['middleware' => 'web'], function () {

    // Authentication Routes...
    $this->get('login', 'Auth\AuthController@showLoginForm');
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    $this->group(['middleware' => 'auth'], function () {
        $this->get('/', function () {
            return redirect('home');
        });

        $this->get('/home', 'HomeController@index');

        $this->resource('books', 'BooksController');
        $this->resource('persons', 'PersonsController', ['except' => ['edit']]);
        
        $this->resource('users', 'UsersController');
        $this->resource('roles', 'RolesController', ['except' => ['edit']]);

        $this->get('books/{books}/associations', ['as' => 'books.associations.index', 'uses' => 'BooksPersonController@showBook']);

        $this->get('persons/book/{association}', ['as' => 'persons.book', 'uses' => 'BooksPersonController@show']);
        $this->get('persons/{person}/add-book', ['as' => 'persons.add-book', 'uses' => 'BooksPersonController@personAddBook']);
        $this->post('persons/{person}/add-book', ['as' => 'persons.add-book.store', 'uses' => 'BooksPersonController@personStoreBook']);

        $this->get('admin/publish', ['as' => 'admin.publish.index', 'uses' => 'ElasticSyncController@index']);
    });
    
});

$this->group(['middleware' => 'api'], function() {
    $this->resource('persons.prints', 'PersonPrintController', ['except' => ['edit']]);
    $this->resource('persons.inheritances', 'PersonInheritanceController', ['except' => ['edit']]);
});
