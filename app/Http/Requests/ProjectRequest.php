<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectRequest extends Request
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
            'title'=>'required|min:3|max:50',
            'line_1'=>'required',
            'line_2'=>'',
            'city'=>'required|regex:/^[(a-zA-Z\s)]+$/u',
            'state'=>'required|alpha',
            'postal_code'=>'required|digits_between:4,8',
            'country'=>'required|alpha'
        ];
    }
}
