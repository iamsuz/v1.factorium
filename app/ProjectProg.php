<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectProg extends Model
{
     protected $fillable = ['project_id','updated_date','progress_description','progress_details','video_url', 'image_path','request_funds','amount','is_voting'];

     public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function votes()
    {
    	return $this->hasMany('App\ProjectProgVote');
    }
}
