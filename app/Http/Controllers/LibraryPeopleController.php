<?php

namespace App\Http\Controllers;

use App\Events\StoreLibraryPersonEvent;
use App\Filters\Shared\DuplicateEntryFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\CombinePeopleRequest;
use App\Http\Requests\IndexLibraryPeopleRequest;
use App\Http\Requests\StoreLibraryPersonRequest;
use App\Http\Requests\UpdateLibraryPersonRequest;
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

        $people = $this->prepareCollection('last_library_person_index', $people, $request, 25);

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
     * @param $libraryPerson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function combine($libraryPerson)
    {
        $person = LibraryPerson::findOrFail($libraryPerson);

        return view('librarypeople.combine', ['person' => $person]);
    }

    /**
     * @param CombinePeopleRequest $request
     * @param $libraryperson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCombine(CombinePeopleRequest $request, $libraryperson)
    {
        $person = LibraryPerson::find($libraryperson);

        $other = LibraryPerson::find($request->input('person'));

        $request->persist($person, $other);

        return redirect()
            ->to(referrer_url('last_library_person_index', route('librarypeople.index')))
            ->with('success', 'Personen zusammengeführt');
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

    /**
     * @param UpdateLibraryPersonRequest $request
     * @param LibraryPerson $libraryperson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLibraryPersonRequest $request, LibraryPerson $libraryperson)
    {
        $request->persist($libraryperson);

        return redirect()
            ->back()
            ->with('success', 'Die Änderungen wurden gespeichert!');
    }

    protected function filters()
    {
        return [
            new TrashFilter('library'),
            // new NameFilter(),
            new PrefixFilter('name'),
            new DuplicateEntryFilter('library_people', 'name'),
            new OnlyTrashedFilter('library.people'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                $builder->orderBy('name', $direction);

                return 'name';
            }),
        ];
    }
}
