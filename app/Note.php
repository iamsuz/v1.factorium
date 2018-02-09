<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'admin_id', 'from_admin', 'content'];

    /**
     * belongs to relationship with users
     * @return instance
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
