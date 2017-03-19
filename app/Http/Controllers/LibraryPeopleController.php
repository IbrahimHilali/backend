<?php

namespace App\Http\Controllers;

use App\Events\StoreLibraryPersonEvent;
use App\Http\Requests\StoreLibraryPersonRequest;
use Grimm\LibraryPerson;
use Illuminate\Http\Request;

class LibraryPeopleController extends Controller
{

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
}
