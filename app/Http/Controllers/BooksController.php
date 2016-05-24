<?php

namespace App\Http\Controllers;

use App\Events\DestroyBookEvent;
use App\Events\StoreBookEvent;
use App\Events\UpdateBookEvent;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\IndexBookRequest;
use Grimm\Book;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBookRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexBookRequest $request)
    {
        $books = Book::query();

        if ($request->has('trash')) {
            session(['book.trash' => $request->get('trash')]);
        }

        if (session('book.trash')) {
            $books->withTrashed();
        }

        if ($request->has('title')) {
            $books = $books->searchByTitle($request->get('title'));
        }

        if ($request->has('prefix')) {
            $books->byPrefix($request->get('prefix'), 'short_title');
        }

        $this->preparePrefixDisplay($request->get('prefix'), Book::prefixesOfLength('short_title', 2)->get());

        $books = $this->prepareCollection('last_book_index', $books, $request,
            function ($builder) {
                $builder->orderBy('short_title')->orderBy('volume')
                    ->orderBy('volume_irregular')
                    ->orderBy('edition');
                return 'identification';
            }, 50);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $book = $request->persist();

        event(new StoreBookEvent($book, $request->user()));

        return redirect()
            ->route('books.show', ['id' => $book->id])
            ->with('success', trans('books.save'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::withTrashed()->details()->findOrFail($id);

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookUpdateRequest $request
     * @param Book $books
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $books)
    {
        $request->persist($books);

        event(new UpdateBookEvent($books, $request->user()));

        return redirect()
            ->route('books.show', ['id' => $books->id])
            ->with('success', 'Die Änderungen wurden gespeichert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Book $books
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Book $books)
    {

        $books->delete();

        event(new DestroyBookEvent($books, $request->user()));

        return redirect()
            ->route('books.index')
            ->with('success', trans('books.delete'));
    }

    public function restore(DestroyBookEvent $request, $id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);

        $book->restore();

        return redirect()->route('books.show', [$id])->with('success', 'Das Buch wurde wiederhergestellt!');
    }
}
