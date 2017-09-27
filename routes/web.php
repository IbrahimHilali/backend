<?php

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

    $this->post('people/{id}/restore', ['as' => 'people.restore', 'uses' => 'PersonsController@restore']);
    $this->post('books/{id}/restore', ['as' => 'books.restore', 'uses' => 'BooksController@restore']);
    $this->post('librarybooks/{id}/restore',
        ['as' => 'librarybooks.restore', 'uses' => 'LibraryBooksController@restore']);

    // Users
    $this->resource('users', 'UsersController');
    $this->resource('roles', 'RolesController', ['except' => ['edit']]);

    // Grimm Library
    $this->resource('librarybooks', 'LibraryBooksController', ['except' => ['edit']]);
    $this->get('librarybooks/{book}/relation/{name}',
        ['as' => 'librarybooks.relation', 'uses' => 'LibraryBooksController@relation']);
    $this->post('librarybooks/{book}/relation/{name}', 'LibraryBooksController@storeRelation');
    $this->delete('librarybooks/{book}/relation/{name}', 'LibraryBooksController@deleteRelation');

    $this->get('librarypeople/search', 'LibraryPeopleController@search');
    $this->resource('librarypeople', 'LibraryPeopleController', ['only' => ['index', 'show', 'store']]);

    // Associations (user-book)
    $this->get('books/{books}/associations',
        ['as' => 'books.associations.index', 'uses' => 'BooksPersonController@showBook']);
    $this->post('books/{books}/associations',
        ['as' => 'books.associations.store', 'uses' => 'BooksPersonController@bookStorePerson']);

    $this->get('people/book/{association}', ['as' => 'people.book', 'uses' => 'BooksPersonController@show']);
    $this->delete('people/book/{association}',
        ['as' => 'people.book.delete', 'uses' => 'BooksPersonController@destroy']);

    $this->get('people/{person}/add-book',
        ['as' => 'people.add-book', 'uses' => 'BooksPersonController@personAddBook']);
    $this->post('people/{person}/add-book',
        ['as' => 'people.add-book.store', 'uses' => 'BooksPersonController@personStoreBook']);

    // Administration
    $this->get('admin/publish', ['as' => 'admin.deployment.index', 'uses' => 'DeploymentController@index']);

    $this->get('history/since', ['as' => 'history.since', 'uses' => 'HistoryController@since']);
});