<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFAQ extends Model
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question','answer'];

    /**
     * belongs to relationship with projects
     * @return instance
     */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
