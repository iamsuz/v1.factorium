<?php

namespace App;
// use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name','last_name', 'username', 'email', 'password', 'phone_number', 'date_of_birth', 'gender', 'last_login', 'active','verify_id','activated_on','registration_site','account_name','bsb','account_number','line_1','line_2','city','state','postal_code','country','country_code','bank_name','withdraw_account_name','withdraw_bsb','withdraw_account_number','withdraw_bank_name','tfn'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * This attributes makes date in Carbon form dates
     * @var array
     */
    protected $dates = ['date_of_birth','activated_on', 'last_login'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user)
        {
            $user->activation_token = str_random(40);
        });
    }

    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }

    /**
     * this is a mutator to add username using frist_name
     * @param $value
     */
    // public function setFirstNameAttribute($value)
    // {
    //     $this->attributes['first_name'] = $value;
    //     $this->attributes['username'] = str_slug($value.' '.rand(1, 9999));
    // }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    /**
     * this is a  one to many relationship between user and projects
     * @return collection
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function investments()
    {
        return $this->belongsToMany('App\Project', 'investment_investor')->withPivot('amount')->withPivot('investing_as')->withPivot('id')->withTimestamps();
    }

    /**
     * this is one to many relationship between user and notes
     * @return
     */
    public function notes()
    {
        return $this->hasMany('App\Note');
    }

    /**
     * this is one to many relationship between user and comments
     * @return
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * this is one to many relationship between user and credits
     * @return
     */
    public function credits()
    {
        return $this->hasMany('App\Credit');
    }

    /**
     * this is one to one relationship between user and idImage
     * @return
     */
    public function idImage()
    {
        return $this->hasOne('App\IdImage');
    }

    public function investmentDoc()
    {
        return $this->hasMany('App\UserInvestmentDocument');
    }

    /**
     * this is one to one relationship between user and metadata
     * @return
     */
    public function userMetadata()
    {
        return $this->hasOne('App\UserMetadata');
    }

    public function accesses()
    {
        return $this->belongsToMany('App\Project', 'project_user')->withTimestamps();;
    }

    /**
     * this is a  one to many relationship between user and projects
     * @return collection
     */
    public function invite_only_projects()
    {
        return $this->hasMany('App\Project', 'developer_id');
    }
    public function social_accounts()
    {
        return $this->hasMany('App\SocialAccount');
    }
    public function aboutUs()
    {
        return $this->hasOne('App\Aboutus');
    }
    public function member()
    {
        return $this->hasMany('App\Member');
    }
}
