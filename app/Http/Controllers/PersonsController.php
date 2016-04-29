<?php

namespace App\Http\Controllers;

use App\Events\DestroyPersonEvent;
use App\Events\StorePersonEvent;
use App\Events\UpdatePersonEvent;
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
        $customData = [];
        if ($request->has('name')) {
            $persons = Person::searchByName($request->get('name'));
            $customData['name'] = $request->get('name');
        } else {
            $persons = Person::query();
        }

        $persons = $this->prepareCollection('last_person_index', $persons, $request,
            function ($builder, $orderByKey, $direction) use ($customData) {
                if (!array_key_exists('name', $customData)) {
                    $builder->orderBy('last_name', $direction)->orderBy('first_name', $direction);
                }
                return 'name';
            }, 75);

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
     * @param StorePersonRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $person = new Person();

        $this->updatePersonModel($request, $person);
        
        event(new StorePersonEvent($person, $request->user()));

        return redirect()->route('persons.show', [$person->id])->with('success',
            'Die Person wurde erfolgreich erstellt!');
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

        event(new UpdatePersonEvent($persons, $request->user()));

        return redirect()->route('persons.show', ['persons' => $persons->id])->with('success',
            'Eintrag erfolgreich aktualisiert!');
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

        event(new DestroyPersonEvent($persons, $request->user()));

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

        $person->birth_date = $request->get('birth_date');
        $person->death_date = $request->get('death_date');

        $person->bio_data = $request->get('bio_data');
        $person->bio_data_source = $request->get('bio_data_source');

        $person->add_bio_data = $request->get('add_bio_data');

        $person->source = $request->get('source');

        $person->is_organization = $request->get('is_organization');

        $person->auto_generated = $request->get('auto_generated');

        $person->save();
    }
}
