<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','line_1', 'line_2', 'street', 'city', 'state', 'postal_code', 'country', 'phone_number', 'latitude', 'longitude'];

    /**
     * this is a many to many relationship between user and their roles
     * @return project instance
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * mutatore
     * @param [type] $value [description]
     */
    public function setCountryAttribute($value)
    {
        $this->attributes['country_code'] = $value;
        $countries = \App\Http\Utilities\Country::all();
        $country = array_search ($value, $countries);
        $this->attributes['country'] = $country;
    }
}
