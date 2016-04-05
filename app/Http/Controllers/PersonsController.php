<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPersonRequest;
use App\Http\Requests\IndexPersonRequest;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonDataRequest;
use Carbon\Carbon;
use Grimm\Person;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PersonsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPersonRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPersonRequest $request)
    {
        if ($request->has('name')) {
            $persons = Person::searchByName($request->get('name'));
        } else {
            $persons = Person::query();
        }

        $orderByKey = $request->get('order-by', 'name');
        $direction = ($request->get('direction', 0)) ? 'desc' : 'asc';

        if ($orderByKey === 'name') {
            $persons->orderBy('last_name', $direction)->orderBy('first_name', $direction);
        } else {
            $persons->orderBy($orderByKey, $direction);
        }
        $persons = $persons->paginate(20);

        $this->preserveIndexSet($request, $persons, $orderByKey);

        return view('persons.index', compact('persons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $person = new Person();

        $this->updatePersonModel($request, $person);

        return redirect()->route('persons.show', [$person->id])->with('success', 'Die Person wurde erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = Person::with([
            'information.code' => function ($query) {
                $query->orderBy('person_codes.name');
            },
            'prints' => function ($query) {
                $query->orderBy('year', 'asc');
            },
            'inheritances',
            'bookAssociations.book' => function ($query) {
                $query->orderBy('books.title');
            }
        ])->findOrFail($id);

        return view('persons.show', compact('person'));
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
     * @param UpdatePersonDataRequest $request
     * @param Person $persons
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonDataRequest $request, Person $persons)
    {
        $this->updatePersonModel($request, $persons);
        return redirect()->route('persons.show', ['persons' => $persons->id])->with('success', 'Eintrag erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPersonRequest $request
     * @param Person $persons
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPersonRequest $request, Person $persons)
    {
        $persons->delete();

        return redirect()->route('persons.index')->with('success', 'Die Person wurde erfolgreich gelöscht!');
    }

    /**
     * TODO: Extract this method
     * @param $request
     * @param Person $person
     */
    private function updatePersonModel($request, Person $person)
    {
        $person->last_name = $request->get('last_name');
        $person->first_name = $request->get('first_name');

        if ($request->has('birth_date')) {
            $person->birth_date = new Carbon($request->get('birth_date'));
        } else {
            $person->birth_date = null;
        }

        if ($request->has('death_date')) {
            $person->death_date = new Carbon($request->get('death_date'));
        } else {
            $person->death_date = null;
        }

        $person->bio_data = $request->get('bio_data');
        $person->bio_data_source = $request->get('bio_data_source');

        $person->add_bio_data = $request->get('add_bio_data');

        $person->source = $request->get('source');

        $person->is_organization = $request->get('is_organization');

        $person->auto_generated = $request->get('auto_generated');

        $person->save();
    }

    /**
     * @param Request $request
     * @param $persons
     * @param $orderByKey
     */
    protected function preserveIndexSet(Request $request, $persons, $orderByKey)
    {
        session([
            'last_person_index' => [
                'page' => $persons->currentPage(),
                'order-by' => $orderByKey,
                'direction' => $request->get('direction', 0)
            ]
        ]);
    }
}
