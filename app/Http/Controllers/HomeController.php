<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Grimm\Book;
use Grimm\Person;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestPeopleCreated = Person::latest()->take(5)->get();
        $latestBooksCreated = Book::latest()->take(5)->get();

        $latestPeopleUpdated = Person::orderBy('updated_at', 'desc')->take(5)->get();
        $latestBooksUpdated = Book::orderBy('updated_at', 'desc')->take(5)->get();

        return view(
            'home',
            compact('latestPeopleCreated', 'latestBooksCreated', 'latestPeopleUpdated', 'latestBooksUpdated')
        );
    }
}
