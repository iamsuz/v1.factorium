<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedulerJob extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'scheduler_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type'];

    /**
     * Has Many relationship with investor_project_tokens
     * @return instance
     */
    public function investor_project_token()
    {
    	return $this->hasMany('App\InvestorProjectToken');
    }
}
