<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','title', 'slug', 'description', 'type', 'additional_info', 'button_label', 'active', 'activated_on', 'start_date', 'completion_date', 'invite_only', 'developer_id','property_type', 'is_coming_soon', 'show_invest_now_button', 'show_download_pdf_page','project_site', 'project_rank', 'project_prospectus_text'];

    /**
     * dates fields
     */
    protected $dates = ['start_date','completion_date', 'activated_on'];

    /**
     * this is a many to many relationship between user and their roles
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function location()
    {
        return $this->hasOne('App\Location');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function media()
    {
        return $this->hasMany('App\Media');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function investment()
    {
        return $this->hasOne('App\Investment');
    }

    /**
     * may to may relationship between projects and documents
     * @return collection
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function investmentDocuments()
    {
        return $this->hasMany('App\UserInvestmentDocument');
    }
    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value.' '.rand(1, 999));
    }

    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setActiveAttribute($value)
    {
        if($value != 0) {
            $this->attributes['active'] = $value;
            $this->attributes['activated_on'] = Carbon::now();
        } else {
            $this->attributes['active'] = $value;
        }
    }

    /**
     * this is a many to many relationship between user and their investors
     * @return collection
     */
    public function investors()
    {
        return $this->belongsToMany('App\User', 'investment_investor')->withPivot('amount')->withTimestamps();
    }

    /**
     * may to may relationship between projects and projects faqs
     * @return collection
     */
    public function projectFAQs()
    {
        return $this->hasMany('App\ProjectFAQ');
    }

    /**
     * may to may relationship between projects and comments
     * @return collection
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function developer()
    {
        return $this->belongsTo('App\User', 'developer_id');
    }

    public function invited_users()
    {
        return $this->belongsToMany('App\User', 'project_user')->withTimestamps();;
    }

    public function project_progs()
    {
        return $this->hasMany('App\ProjectProg');
    }

    public function projectspvdetail()
    {
        return $this->hasOne('App\ProjectSpvDetail');
    }
    public function projectconfiguration()
    {
        return $this->hasOne('App\ProjectConfiguration')->join('project_configuration_partials', 'project_configurations.project_id', '=', 'project_configuration_partials.project_id');
        // ->join('project_configuration_partials', function ($join) {
        //     $join->on('project_configurations.project_id', '=', 'contacts.user_id')
        //          ->where('contacts.user_id', '>', 5);
        // })
        // ->get();
    }

    public function projectconfigurationpartial()
    {
        return $this->hasOne('App\ProjectConfigurationPartial');
    }

    public function investing_joint()
    {
        return $this->hasMany('App\InvestingJoint');
    }
    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
    public function position()
    {
        return $this->hasMany('App\Position');
    }
}
