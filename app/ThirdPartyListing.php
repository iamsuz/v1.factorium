<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyListing extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'third_party_listings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'list_on_site', 'active'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
