<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubdivideRequest extends Request
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
            'first_name'=>'required|alpha|min:1|max:50',
            'last_name'=>'required|alpha|min:1|max:50',
            'email'=>'required|email|max:255',
            'phone_number'=>'required|integer|min:10',
            'line_1'=>'required',
            'line_2'=>'required',
            'city'=>'required|alpha',
            'state'=>'required|alpha',
            'postal_code'=>'required|digits_between:4,8',
            'country'=>'required|alpha'
        ];
    }
}
