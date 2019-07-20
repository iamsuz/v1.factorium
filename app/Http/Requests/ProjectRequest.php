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
            'description'=>'required',
            'goal_amount'=>'required|integer'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Receivable Name is required!',
            'title.min' => 'The Receivable Name must be at least 3 characters.',
            'title.max' => 'The Receivable Name may not be greater than 50 characters.',
            'description.required' => 'Invoice issued to is required!',
            'goal_amount.required' => 'Amount is required!',
            'goal_amount.integer' => 'Amount should be integer'
        ];
    }
}
