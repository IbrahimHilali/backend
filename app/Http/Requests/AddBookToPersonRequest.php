<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddBookToPersonRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('people.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'book' => 'required|exists:books,id',
            'page' => 'required|numeric|min:1',
            'page_description' => 'string',
            'page_to' => 'numeric|min:1',
            'line' => 'numeric|min:1',
        ];
    }
}
