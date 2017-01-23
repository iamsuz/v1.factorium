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
    protected $fillable = ['user_id','title', 'slug', 'description', 'type', 'additional_info', 'button_label', 'active', 'activated_on', 'start_date', 'completion_date', 'invite_only', 'developer_id','property_type', 'is_coming_soon', 'show_invest_now_button', 'show_download_pdf_page'];

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
        return $this->belongsToMany('App\User', 'investment_investor')->withTimestamps();
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
}
