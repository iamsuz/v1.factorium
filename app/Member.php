<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['user_id','aboutus_id','founder_name','founder_subheading','founder_content','founder_image_url'];

    public function aboutUs()
    {
    	return $this->hasOne('App\Aboutus');
    }
    public function user()
    {
    	return $this->hasOne('App\User');
    }
}
