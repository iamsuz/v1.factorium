<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestingJoint extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'investing_joint';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','investment_investor_id', 'joint_investor_first_name','joint_investor_last_name','investing_company','account_name','bsb','account_number','line_1','line_2','city','state','postal_code','country','country_code','tfn','swift_code'];


    public function investmentInvestors()
    {
        # code...
        return $this->belongsTo('App\InvestmentInvestor');
    }
}
