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
     * @param $personId
     * @return \Illuminate\Http\Response
     */
    public function index($personId)
    {
        $person = Person::findOrFail($personId);
        return $person->prints;
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
     * @param $personId
     * @param $printId
     * @return \Illuminate\Http\Response
     */
    public function show($personId, $printId)
    {
        $person = Person::findOrFail($personId);

        return $person->prints()->find($printId);
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
     * @param $personId
     * @param $printId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $personId, $printId)
    {
        $person = Person::findOrFail($personId);

        /** @var PersonPrint $print */
        $print = $person->prints()->find($printId);

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
