<?php

namespace App\Http\Controllers;

use App\Events\DestroyLibraryEvent;
use App\Events\DestroyLibraryRelationEvent;
use App\Events\StoreLibraryEvent;
use App\Events\UpdateLibraryEvent;
use App\Filters\Library\TitleFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\DestroyLibraryRelationRequest;
use App\Http\Requests\DestroyLibraryRequest;
use App\Http\Requests\IndexLibraryRequest;
use App\Http\Requests\ShowLibraryRequest;
use App\Http\Requests\StoreLibraryRelationRequest;
use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use Grimm\LibraryBook;
use Illuminate\Http\Request;

class LibraryBooksController extends Controller
{

    use FiltersEntity;

    /**
     * Display a listing of the resource.
     *
     * @param IndexLibraryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexLibraryRequest $request)
    {
        $books = LibraryBook::query();

        $this->filter($books);

        $this->preparePrefixDisplay($request->get('prefix'), LibraryBook::prefixesOfLength('title', 2)->get());

        $books = $this->prepareCollection('last_person_index', $books, $request, 200);

        return view('librarybooks.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('librarybooks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLibraryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibraryRequest $request)
    {
        $book = $request->persist();

        event(new StoreLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.show', ['id' => $book->id])
            ->with('success', trans('librarybooks.store_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowLibraryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowLibraryRequest $request, $id)
    {
        $book = LibraryBook::withTrashed()->with([
            'authors',
            'editors',
            'translators',
            'illustrators'
        ])->findOrFail($id);

        return view('librarybooks.show', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLibraryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::query()->findOrFail($id);

        $request->persist($book);

        event(new UpdateLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.show', ['id' => $book->id])
            ->with('success', 'Die Änderungen wurden gespeichert');
    }

    /**
     * @param LibraryBook $book
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relation(LibraryBook $book, $name)
    {
        return view('librarybooks.relation', compact('name', 'book'));
    }

    /**
     * @param StoreLibraryRelationRequest $request
     * @param LibraryBook $book
     * @param $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRelation(StoreLibraryRelationRequest $request, LibraryBook $book, $relation)
    {
        $request->persist($book, $relation);

        // TODO: trigger event

        return redirect()
            ->route('librarybooks.show', [$book])
            ->with('success', 'Verknüpfung wurde erstellt');
    }

    public function deleteRelation(DestroyLibraryRelationRequest $request, LibraryBook $book, $relation)
    {
        $request->persist($book, $relation);

        event(
            new DestroyLibraryRelationEvent($book, $request->user())
        );

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLibraryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::query()->findOrFail($id);

        $request->persist($book);

        event(new DestroyLibraryEvent($book, $request->user()));

        return redirect()
            ->route('librarybooks.index')
            ->with('success', trans('librarybooks.deleted_success'));
    }

    /**
     * @param DestroyLibraryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(DestroyLibraryRequest $request, $id)
    {
        /** @var LibraryBook $book */
        $book = LibraryBook::onlyTrashed()->findOrFail($id);

        $book->restore();

        return redirect()
            ->route('library.show', [$id])
            ->with('success', 'Das Buch wurde wiederhergestellt!');
    }

    protected function filters()
    {
        return [
            new TrashFilter('library'),
            new TitleFilter(),
            new PrefixFilter('title'),
            new OnlyTrashedFilter('library'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                $builder->orderByRaw('ABS(catalog_id) ' . $direction)
                    ->orderBy('catalog_id', $direction);

                return 'cat_id';
            }),
        ];
    }
}
