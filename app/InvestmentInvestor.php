<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentInvestor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'investment_investor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'investment_id','amount', 'accepted','investment_confirmation'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    public function investment()
    {
    	return $this->belongsTo('App\Investment');
    }
}
