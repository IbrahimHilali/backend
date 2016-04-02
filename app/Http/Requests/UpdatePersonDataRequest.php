<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePersonDataRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: fix as soon as roles and stuff are established
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name' => 'required',
            'first_name' => 'string',
            'birth_date' => 'date',
            'death_date' => 'date',
            'bio_data'  => 'string',
            'is_organization' => 'required|boolean',
            'auto_generated' => 'required|boolean'
        ];
    }
}
