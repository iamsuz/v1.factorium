<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentRequest extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'investment_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'is_link_expired'];

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * belongs to relationship with projects
     * @return instance
     */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    /**
     * belongs to relationship with users
     * @return instance
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
