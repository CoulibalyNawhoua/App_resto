<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'first_name' => 'required',
            'last_name'  => 'required',

            'email'  => 'email|unique:users|required',
            'password' => 'required',
            'roles' => 'required|array',
            'password_confirmation' => 'required|same:password'
            // 'profil_id' => 'required',
        ];
    }
}
