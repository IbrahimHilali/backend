<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewPrintToPersonRequest;
use App\Http\Requests\UpdatePrintRequest;
use Gate;
use Grimm\Person;
use Grimm\PersonPrint;
use Illuminate\Http\Request;

use App\Http\Requests;

class PersonPrintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Person $people
     *
     * @return \Illuminate\Http\Response
     */
    public function index($people)
    {
        $people = Person::withTrashed()->findOrFail($people);
        return $people->prints;
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
     * @param AddNewPrintToPersonRequest $request
     * @param Person                     $people
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewPrintToPersonRequest $request, Person $people)
    {
        $print = new PersonPrint();
        $print->entry = $request->get('entry');
        $print->year = $request->get('year');
        $people->prints()->save($print);

        if ($request->ajax()) {
            return $people->prints;
        }

        return redirect()->route('people.show', ['people' => $people->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Person $people
     * @param        $printId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Person $people, $printId)
    {
        return $people->prints()->findOrFail($printId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePrintRequest $request
     * @param Person             $people
     * @param                    $printId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrintRequest $request, Person $people, $printId)
    {

        /** @var PersonPrint $print */
        $print = $people->prints()->find($printId);

        $print->entry = $request->get('entry');
        $print->year = $request->get('year');

        $print->save();

        return $print;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $people
     * @param        $printId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $people, $printId)
    {
        $this->authorize('people.update');

        $people->prints()->find($printId)->delete();

        return $people->prints;
    }
}
