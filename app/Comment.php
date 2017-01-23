<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	/**
     * dates fields
     */
    protected $fillable = ['project_id', 'user_id', 'reply_id', 'text'];

    /**
     * this is a many to many relationship between Project and their comments
     * @return user instance
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * this is a many to many relationship between Project and their comments
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function votes()
    {
        return $this->hasMany('App\CommentVote');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'reply_id');
    }
}
