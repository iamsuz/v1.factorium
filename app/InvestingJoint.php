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
    protected $fillable = ['project_id','investment_investor_id', 'joint_investor_first_name','joint_investor_last_name','investing_company'];
}
