<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['site_configuration_id','driver','host','port','from','username','password','encryption'];

    /**
     * this is a many to many relationship between user and their roles
     * @return project instance
     */
    public function siteConfiguration()
    {
        return $this->belongsTo('App\SiteConfiguration');
    }
}
