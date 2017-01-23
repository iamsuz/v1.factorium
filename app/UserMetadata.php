<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMetadata extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','drivers_license_number', 'passport_number', 'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code'];

    /**
     * this is a many to many relationship between user and their metadata
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
