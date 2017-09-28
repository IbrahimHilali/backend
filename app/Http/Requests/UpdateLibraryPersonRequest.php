<?php

namespace App\Http\Requests;

use Grimm\LibraryBook;
use Grimm\LibraryPerson;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLibraryPersonRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('library.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Persists changes of library person to database
     *
     * @param LibraryPerson $person
     * @return bool
     */
    public function persist(LibraryPerson $person)
    {
        $person->name = $this->input('name');
        $person->note = $this->input('note');

        return $person->save();
    }
}
