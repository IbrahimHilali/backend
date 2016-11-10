<?php

namespace App\Http\Controllers;

use Grimm\PersonReference;
use Illuminate\Http\Request;

use App\Http\Requests;

class PersonReferenceController extends Controller
{

    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        // Form with unidirectional / bidirectional
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {

    }

    /**
     * @param Request $request
     * @param PersonReference $reference
     */
    public function edit(Request $request, PersonReference $reference)
    {

    }

    /**
     * @param Request $request
     * @param PersonReference $reference
     */
    public function update(Request $request, PersonReference $reference)
    {

    }

    /**
     * @param Request $request
     * @param PersonReference $reference
     */
    public function destroy(Request $request, PersonReference $reference)
    {
        // be able to delete both directions
    }
}
