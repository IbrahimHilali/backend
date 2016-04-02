<?php

namespace App\Http\Controllers;

use Grimm\Person;
use Grimm\PersonPrint;
use Illuminate\Http\Request;

use App\Http\Requests;

class PersonPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Person $persons
     * @return \Illuminate\Http\Response
     */
    public function index(Person $persons)
    {
        //$person = Person::findOrFail($personId);
        return $persons->prints;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Person $persons
     * @param $printId
     * @return \Illuminate\Http\Response
     */
    public function show(Person $persons, $printId)
    {
        //$person = Person::findOrFail($personId);

        return $persons->prints()->findOrFail($printId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param Person $persons
     * @param $printId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $persons, $printId)
    {

        /** @var PersonPrint $print */
        $print = $persons->prints()->find($printId);

        $print->entry = $request->get('entry');
        $print->year = $request->get('year');

        $print->save();

        return $print;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}