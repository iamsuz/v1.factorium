<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferRegistration extends Model
{
    protected $fillable = ['user_registration_id', 'project_id', 'investment_id','amount_to_invest', 'investing_as','joint_fname', 'joint_lname', 'trust_company', 'account_name', 'bsb', 'account_number', 'signature_data', 'line_1', 'line_2','city','state','postal_code','country','country_code','tfn','application_path','interested_to_buy'];

    public function user()
    {
    	return $this->belongsTo('App\UserRegistration');
    }
}
