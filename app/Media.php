<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'type', 'filename','path','thumbnail_path','caption','extension','project_site'];

    /**
     * this is a many to many relationship between user and their roles
     * @return project instance
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
