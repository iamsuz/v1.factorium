<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	/**
	 * The database table used by the model.
	 * 
	 * @var string 
	 */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','project_id','investment_investor_id','transaction_type','transaction_date','amount','rate','number_of_shares'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    public function investmentInvestors()
    {
        return $this->belongsTo('App\InvestmentInvestor');
    }
}
