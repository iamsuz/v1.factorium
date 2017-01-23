<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nav_footer_color', 'heading_color'];

    /**
     * belongs to relationship with users
     * @return instance
     */
    public function user()
    {
        $this->belongsTo('App\User');
    }
}
