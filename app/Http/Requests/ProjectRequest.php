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
            'title'=>'min:3|max:50',
            'description'=>'required',
            'invoice_amount'=>'required|integer',
            'asking_amount'=>'required|integer',
            'due_date'=>'required|date|after:today',
            'invoice_issued_from'=>'required',
            'invoice_issue_from_email'=>'required|email'
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
            'invoice_amount.required' => 'Invoice amount is required!',
            'invoice_amount.integer' => 'Invoice amount should be integer',
            'asking_amount.required' => 'Asking Price is required!',
            'asking_amount.integer' => 'Asking Price should be integer'
        ];
    }
}
