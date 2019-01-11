<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvestmentDocument extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_investment_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','investment_investor_id','investing_joint_id','filename', 'type','path','extenstion','verified','user_id','document_url'];

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function investors()
    {
        return $this->belongsTo('App\InvestmentInvestor');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
