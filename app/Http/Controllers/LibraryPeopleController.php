<?php

namespace App\Http\Controllers;

use App\Events\StoreLibraryPersonEvent;
use App\Filters\People\NameFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\IndexLibraryPeopleRequest;
use App\Http\Requests\StoreLibraryPersonRequest;
use Grimm\LibraryPerson;
use Illuminate\Http\Request;

class LibraryPeopleController extends Controller
{

    use FiltersEntity;

    public function index(IndexLibraryPeopleRequest $request)
    {
        $people = LibraryPerson::query();

        $this->filter($people);

        $this->preparePrefixDisplay($request->get('prefix'), LibraryPerson::prefixesOfLength('name', 2)->get());

        $people = $this->prepareCollection('last_person_index', $people, $request, 25);

        return view('librarypeople.index', compact('people'));
    }

    public function show($id)
    {
        $person = LibraryPerson::withTrashed()
            ->with([
                'written',
                'edited',
                'translated',
                'illustrated'
            ])
            ->findOrFail($id);

        return view('librarypeople.show', compact('person'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = LibraryPerson::searchByName($request->get('name'));

        return $query->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLibraryPersonRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibraryPersonRequest $request)
    {
        $person = $request->persist();

        event(new StoreLibraryPersonEvent($person, $request->user()));

        return redirect()
            ->route('librarybooks.show', ['book' => $request->input('book')])
            ->with('success', 'Die Person und Verknüpfung wurden gespeichert.');
    }

    protected function filters()
    {
        return [
            new TrashFilter('library'),
            // new NameFilter(),
            new PrefixFilter('name'),
            new OnlyTrashedFilter('library.people'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                $builder->orderBy('name', $direction);

                return 'name';
            }),
        ];
    }
}
