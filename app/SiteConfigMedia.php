<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfigMedia extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_config_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['site_configuration_id', 'type', 'filename','path', 'thumbnail_path', 'caption', 'extension'];

    public function siteconfiguration()
    {
        return $this->hasOne('App\SiteConfiguration');
    }
}
