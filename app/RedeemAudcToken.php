<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemAudcToken extends Model
{
	protected $table = 'redeem_audc_tokens';

	protected $fillable = ['user_id', 'amount', 'paid_in','confirmed','confirmed_by'];


	public function user()
	{
		return $this->belongsTo('App\User');
	}
}