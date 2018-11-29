<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserRegistration extends Model
{
	use Authenticatable, Authorizable, CanResetPassword;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user)
        {
            $user->token = str_random(40);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'active','token', 'role', 'registration_site','eoi_token','investment_period','investment_amount','first_name','last_name','phone_number','eoi_project', 'email_attempts'];

    /**
     * This attributes makes date in Carbon form dates
     * @var array
     */
    protected $dates = ['activated_on'];

    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }
    public function offer_registration()
    {
        return $this->hasOne('App\OfferRegistration');
    }
}
