<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectInterest extends Model
{
	
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_interests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','email', 'phone_number'];

    /**
     * belongs to relationship with projects
     * @return instance
     */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
