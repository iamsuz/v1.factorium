<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'token', 'email', 'accepted', 'accepted_on'];

    /**
     * This attributes makes date in Carbon form dates
     * @var array
     */
    protected $dates = ['accepted_on'];
}
