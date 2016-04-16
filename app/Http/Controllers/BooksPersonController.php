<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookToPersonRequest;
use Grimm\Book;
use Grimm\BookPersonAssociation;
use Grimm\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class BooksPersonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Person $person
     * @return \Illuminate\Http\Response
     */
    public function personAddBook(Request $request, Person $person)
    {
        $searchTitle = $request->get('search');

        if ($searchTitle) {
            /** @var LengthAwarePaginator $books */
            $books = Book::searchByTitle($searchTitle)->paginate(10);

            $books->appends(['search' => $request->get('search')]);
        } else {
            $books = Book::query()
                ->orderBy('title')
                ->orderBy('volume')
                ->orderBy('volume_irregular')
                ->orderBy('edition')
                ->paginate(10);;
        }

        return view('persons.add-book', compact('books', 'person'));
    }

    /**
     * @param AddBookToPersonRequest $request
     * @param Person $person
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function personStoreBook(AddBookToPersonRequest $request, Person $person)
    {
        $association = new BookPersonAssociation();

        $association->page = $request->input('page');
        $association->page_to = $request->input('page_to') ?: null;
        $association->line = $request->input('line') ?: null;
        $association->page_description = $request->input('page_description') ?: null;

        $association->person()->associate($person);
        $association->book()->associate($request->input('book'));

        $association->save();

        return redirect()
            ->route('persons.book', [$association->id])
            ->with('success', 'Verknüpfung erstellt');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param BookPersonAssociation $association
     * @return \Illuminate\Http\Response
     * @internal param Book $book
     */
    public function show(BookPersonAssociation $association)
    {
        $association->load([
            'book',
            'person'
        ]);

        // TODO: fancy gallery with scan of pages

        return view('books.person', compact('association'));
    }

    public function showBook(Book $books)
    {
        $books->load([
            'personAssociations' => function ($query) {
                return $query->orderBy('page')
                    ->orderBy('line');
            },
            'personAssociations.person' => function ($query) {
                return $query->orderBy('last_name')
                    ->orderBy('first_name');
            }
        ]);

        /** @var Collection $persons */
        $persons = $books->personAssociations->map(function (BookPersonAssociation $association) {
            return $association->person;
        })->unique();

        $associations = [];
        foreach ($books->personAssociations as $association) {
            $associations[$association->person_id][] = $association;
        }

        return view('books.associations', ['book' => $books, 'persons' => $persons, 'associations' => $associations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
