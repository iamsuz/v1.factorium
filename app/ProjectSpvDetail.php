<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectSpvDetail extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_spv_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'spv_name','spv_line_1', 'spv_line_2','spv_city','spv_state','spv_postal_code','spv_country','spv_contact_number', 'spv_md_name', 'certificate_frame'];

    public function project()
    {
        return $this->hasOne('App\Project');
    }
}
