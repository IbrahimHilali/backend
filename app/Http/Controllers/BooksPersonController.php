<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookToPersonRequest;
use App\Http\Requests\AddPersonToBookRequest;
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
        $book = Book::find($request->input('book'));

        $association = $this->storeAssociation($request, $person, $book);

        return redirect()
            ->route('persons.book', [$association->id])
            ->with('success', 'Verknüpfung erstellt');
    }

    /**
     * @param AddPersonToBookRequest $request
     * @param Book $books
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookStorePerson(AddPersonToBookRequest $request, Book $books)
    {
        $person = Person::findOrFail($request->input('person'));

        $association = $this->storeAssociation($request, $person, $books);

        return redirect()
            ->route('books.associations.index', [$books->id])
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

    public function showBook(Request $request, Book $books)
    {
        /*
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
        */

        // Take the latest 15 persons and sort them afterwards.
        // We need to touch a person if an association is added.
        // Other wise, the persons updated_at timestamp is not updated and sorting won't work.

        /** @var Collection $persons */
        $persons = Person::query()
            ->with([
                'bookAssociations' => function ($query) {
                    return $query->orderBy('page')
                        ->orderBy('line');
                }
            ])
            ->whereHas('bookAssociations',
                function ($query) use ($books) {
                    $query->where('book_id', $books->id);
                }
            )
            ->latest()
            ->take(15)
            ->get();

        $persons = $persons->sort(function (Person $personA, Person $personB) {
            $lastNameOrder = strcmp($personA->last_name, $personB->last_name);

            if ($lastNameOrder == 0) {
                return strcmp($personA->first_name, $personB->first_name);
            }

            return $lastNameOrder;
        });

        return view('books.associations', ['book' => $books, 'persons' => $persons]);
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

    /**
     * @param Request $request
     * @param Person $person
     * @param Book $book
     * @return BookPersonAssociation
     */
    protected function storeAssociation(Request $request, Person $person, Book $book)
    {
        $association = new BookPersonAssociation();

        $association->page = $request->input('page');
        $association->page_to = $request->input('page_to') ?: null;
        $association->line = $request->input('line') ?: null;
        $association->page_description = $request->input('page_description') ?: null;

        $association->person()->associate($person);
        $association->book()->associate($book);

        $association->save();

        return $association;
    }
}
