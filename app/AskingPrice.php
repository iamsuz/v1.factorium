<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AskingPrice extends Model
{
    public $table = "asking_prices";
    protected $fillable = ['project_id','user_id','price','amount_of_shares','accepted','type'];

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
