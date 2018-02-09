<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'amount', 'invite_id', 'type'];

    public function user()
    {
    	return $this->belongsToMany('App\User');
    }
}
