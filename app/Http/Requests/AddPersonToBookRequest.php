<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddPersonToBookRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('books.assign');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person' => 'required|exists:persons,id',
            'page' => 'required|numeric|min:1',
            'page_description' => 'nullable|string',
            'page_to' => 'nullable|numeric|min:1',
            'line' => 'nullable|numeric|min:1',
        ];
    }
}
