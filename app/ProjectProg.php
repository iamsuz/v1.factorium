<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectProg extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at','updated_date'];

     protected $fillable = ['project_id','updated_date','progress_description','progress_details','video_url', 'image_path','request_funds','is_voting','start_date','end_date','percent','fund_status'];

     public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function votes()
    {
    	return $this->hasMany('App\ProjectProgVote');
    }
}
