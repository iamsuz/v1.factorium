<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'filename','type', 'path','investing_as','joint_first_name','joint_last_name','trust_or_company', 'extension','verified','joint_id_filename','joint_id_path','joint_id_extension','id_comment','joint_id_comment','company_id_comment'];

    /**
     * this is a many to many relationship between user and their photo
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
