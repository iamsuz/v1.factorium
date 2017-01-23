<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','type', 'filename', 'path', 'extension', 'verified'];

	/**
	 * belongs to relationship with projects
	 * @return instance
	 */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
