<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    public $table = "markets";

    public $timestamps = true;

    protected $fillable = ['project_id','user_id','price','amount_of_shares','accepted','type','is_money_received','is_order_changed','original_shares','market_id'];

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
