<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class UpdateRoleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('users.update');
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
            'users.*' => 'exists:users,id',
            'permissions.*' => 'exists:permissions,id',
        ];
    }
}
