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
    protected $fillable = ['user_id', 'project_id', 'investment_id','amount', 'accepted','investment_confirmation', 'share_certificate_issued_at', 'share_number', 'share_certificate_path', 'is_cancelled', 'is_repurchased', 'signature_data', 'application_path'];

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

    public function investingJoint()
    {
        return $this->hasOne('App\InvestingJoint');
    }
    public function userInvestmentDoc()
    {
        return $this->hasMany('App\UserInvestmentDocument');
    }
    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
    public function wholesaleInvestment()
    {
        return $this->hasOne('App\WholesaleInvestment');
    }
}
