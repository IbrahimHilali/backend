<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewInheritanceToPersonRequest;
use App\Http\Requests\UpdateInheritanceRequest;
use Gate;
use Grimm\Person;
use Grimm\PersonInheritance;
use Illuminate\Http\Request;

use App\Http\Requests;

class PersonInheritanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Person $persons
     * @return \Illuminate\Http\Response
     */
    public function index(Person $persons)
    {
        return $persons->inheritances;
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
     * @param AddNewInheritanceToPersonRequest $request
     * @param Person $persons
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewInheritanceToPersonRequest $request, Person $persons)
    {
        $inheritance = new PersonInheritance();
        $inheritance->entry = $request->get('entry');
        $persons->inheritances()->save($inheritance);

        if ($request->ajax()) {
            return $persons->inheritances;
        }

        return redirect()->route('persons.show', ['persons' => $persons->id])->with('success', 'Nachlass hinzugefügt');
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
     * @param UpdateInheritanceRequest $request
     * @param Person $persons
     * @param $inheritanceId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateInheritanceRequest $request, Person $persons, $inheritanceId)
    {
        /** @var PersonInheritance $inheritance */
        $inheritance = $persons->inheritances()->find($inheritanceId);

        $inheritance->entry = $request->get('entry');

        $inheritance->save();

        return $inheritance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $persons, $inheritanceId)
    {
        if (Gate::allows('people.update')) {
            // TODO: Add permission check
            $persons->inheritances()->find($inheritanceId)->delete();
            return $persons->inheritances;
        }

    }
}
