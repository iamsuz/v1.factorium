<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    /**
     * dates fields
     */
    protected $fillable = ['project_id', 'user_id', 'comment_id', 'value'];

    /**
     * this is a many to many relationship between Comment and their comment votes
     * @return user instance
     */
    public function comment()
    {
    	return $this->belongsTo('App\Comment');
    }

    /**
     * this is a many to many relationship between user and their comment votes
     * @return user instance
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}
