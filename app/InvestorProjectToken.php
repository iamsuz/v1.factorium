<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestorProjectToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'investor_project_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'tokens', 'symbol', 'job_id'];

    /**
     * belongs to relationship with projects
     * @return instance
     */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    /**
     * belongs to relationship with users
     * @return instance
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * belongs to relationship with scheduler_jobs
     * @return instance
     */
    public function scheduler_job()
    {
    	return $this->belongsTo('App\SchedulerJob');
    }
}
