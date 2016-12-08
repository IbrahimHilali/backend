<?php

namespace App\Http\Controllers;

use App\Filters\Library\TitleFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\IndexLibraryRequest;
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
        //
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    protected function filters()
    {
        return [
            new TrashFilter('library'),
            new TitleFilter(),
            new PrefixFilter('title'),
            new OnlyTrashedFilter('library'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                if ($this->filter->applied(SortFilter::class)) {
                    $builder->orderByRaw('ABS(catalog_id) ' . $direction)
                        ->orderBy('catalog_id', $direction);
                }

                return 'cat_id';
            }),
        ];
    }
}
