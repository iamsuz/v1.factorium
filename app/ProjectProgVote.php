<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectProgVote extends Model
{
    protected $fillable = ['project_id','user_id','project_prog_id','value'];

     public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function progress()
    {
    	return $this->belongsTo('App\ProjectProg');
    }
}
