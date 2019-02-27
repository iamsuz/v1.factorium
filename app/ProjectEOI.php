<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectEOI extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_eoi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'user_id', 'user_name', 'user_email', 'phone_number', 'investment_amount', 'invesment_period', 'project_site', 'offer_doc_path', 'offer_doc_name','is_link_sent', 'interested_to_buy','is_accredited_investor','country','country_code'];

    /**
     * belongs to relationship with projects
     * @return instance
     */

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
