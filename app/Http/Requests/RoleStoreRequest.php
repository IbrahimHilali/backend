<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;
use Grimm\Role;

class RoleStoreRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('users.store');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles',
            'users.*' => 'exists:users,id',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function persist()
    {
        $role = new Role();

        $role->name = $this->input('name');

        $role->save();

        foreach($this->input('users') as $id) {
            $role->users()->attach($id);
        }

        foreach($this->input('permissions') as $id) {
            $role->permissions()->attach($id);
        }

        return $role->id;
    }
}
