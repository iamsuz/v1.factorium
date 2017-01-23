<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InvestmentRequest extends Request
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
            'goal_amount'=>'required',
            'minimum_accepted_amount'=>'required',
            'projected_returns'=>'required',
            'hold_period'=>'required',
        ];
    }
}
