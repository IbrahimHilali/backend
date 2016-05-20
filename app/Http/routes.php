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

        $this->get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

        // Books
        $this->resource('books', 'BooksController', ['except' => ['edit']]);

        // Persons
        $this->get('people/search', ['as' => 'people.search', 'uses' => 'PersonsController@search']);
        $this->resource('people', 'PersonsController', ['except' => ['edit']]);

        // Users
        $this->resource('users', 'UsersController');
        $this->resource('roles', 'RolesController', ['except' => ['edit']]);

        // Associations (user-book)
        $this->get('books/{books}/associations', ['as' => 'books.associations.index', 'uses' => 'BooksPersonController@showBook']);
        $this->post('books/{books}/associations', ['as' => 'books.associations.store', 'uses' => 'BooksPersonController@bookStorePerson']);

        $this->get('people/book/{association}', ['as' => 'people.book', 'uses' => 'BooksPersonController@show']);
        $this->get('people/{person}/add-book', ['as' => 'people.add-book', 'uses' => 'BooksPersonController@personAddBook']);
        $this->post('people/{person}/add-book', ['as' => 'people.add-book.store', 'uses' => 'BooksPersonController@personStoreBook']);

        // Administration
        $this->get('admin/publish', ['as' => 'admin.deployment.index', 'uses' => 'DeploymentController@index']);

        $this->get('history/since', ['as' => 'history.since', 'uses' => 'HistoryController@since']);
    });
});

$this->group(['middleware' => 'api'], function() {
    $this->resource('people.prints', 'PersonPrintController', ['except' => ['edit']]);
    $this->resource('people.inheritances', 'PersonInheritanceController', ['except' => ['edit']]);
    $this->post('admin/publish/trigger', ['as' => 'admin.deployment.trigger', 'uses' => 'DeploymentController@triggerDeployment']);
    $this->get('admin/publish/status', ['as' => 'admin.deployment.status', 'uses' => 'DeploymentController@status']);
    $this->post('admin/publish/blankify', ['as' => 'admin.deployment.blankify', 'uses' => 'DeploymentController@blankify']);
});
