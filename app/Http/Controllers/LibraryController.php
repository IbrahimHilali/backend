<?php

namespace App\Http\Controllers;

use App\Events\DestroyLibraryEvent;
use App\Events\StoreLibraryEvent;
use App\Events\UpdateLibraryEvent;
use App\Filters\Library\TitleFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\DestroyLibraryRequest;
use App\Http\Requests\IndexLibraryRequest;
use App\Http\Requests\ShowLibraryRequest;
use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use Grimm\LibraryBook;
use Illuminate\Http\Request;

class LibraryController extends Controller
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

        return view('library.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('library.create');
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
            ->route('library.show', ['id' => $book->id])
            ->with('success', trans('library.store_success'));
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
        $book = LibraryBook::withTrashed()->findOrFail($id);

        return view('library.show', compact('book'));
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
            ->route('library.show', ['id' => $book->id])
            ->with('success', 'Die Änderungen wurden gespeichert');
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
            ->route('library.index')
            ->with('success', trans('library.deleted_success'));
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
