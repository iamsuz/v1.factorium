<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueingToken extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'issueing_tokens';


    protected $fillable = ['user_id','project_id','investment_investor_id','transaction_type','transaction_date','amount','rate','number_of_shares'];

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
