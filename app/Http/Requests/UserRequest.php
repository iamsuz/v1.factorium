<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
        if ($this->isMethod('post')) {
            $rules = [
                'first_name'=>'required|min:1|max:50',
                'last_name'=>'required|min:1|max:50',
                'username'=>'max:255|unique:users,username',
                'email'=>'required|email|max:255|unique:users,email',
                'gender'=>'in:male,female|max:12',
                'password'=>'required|min:6|max:60',
                'phone_number'=>'min:10',
                'role'=>'required',
            ];
        } elseif ($this->isMethod('PATCH')) {
            $rules = [
                'first_name'=>'required|min:1|max:50',
                'last_name'=>'required|min:1|max:50',
                'username'=>'max:255',
                'email'=>'required|email|max:255',
                'gender'=>'in:male,female|max:12',
                'date_of_birth'=>'date_format:Y-m-d|before:today',
                'phone_number'=>'min:10',
            ];
        }
        return $rules;
    }
}
