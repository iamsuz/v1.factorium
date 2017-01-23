<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'filename', 'path','filename_for_id','path_for_id','doc1','doc2', 'verify_id'];

    /**
     * this is a many to many relationship between user and their photo
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
