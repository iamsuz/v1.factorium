<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProspectusDownload extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prospectus_downloads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'project_site'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
