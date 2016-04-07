<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Factory;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('users.update') || $this->user()->id === $this->route('users')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:users,name,'.$this->route('users')->id,
            'email' => 'required|email|unique:users,email,'.$this->route('users')->id,
            'password' => 'sometimes|min:4|confirmed',
        ];
    }

    /**
     * @param $validator
     */
    protected function sometimesRules($validator)
    {
        $validator->sometimes('current_password', 'required|correct_password', function () {
            return $this->user()->cannot('users.update');
        });

        $validator->sometimes('roles.*', 'exists:roles,id', function () {
            return $this->user()->can('users.update');
        });

        $validator->sometimes('api_only', 'required|boolean', function () {
            return $this->user()->can('users.update');
        });
    }

    public function validator(Factory $factory)
    {
        $factory->extend('correct_password', function($attribute, $value, $parameters, $validator) {
            return auth()->validate(['id' => auth()->user()->id, 'password' => $value]);
        });

        $validator =  $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );

        $this->sometimesRules($validator);

        return $validator;
    }
}
