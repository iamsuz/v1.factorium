<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectProg extends Model
{
     protected $fillable = ['project_id','updated_date','progress_description','progress_details','video_url'];

     public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
