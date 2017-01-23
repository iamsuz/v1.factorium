<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
	public $table = "aboutus";
    protected $fillable = ['user_id','main_heading','sub_heading','content'];

    public function user()
    {
        return $this->hasOne('App\User');
    }
    public function member()
    {
    	return $this->hasMany('App\Member');
    }
}
