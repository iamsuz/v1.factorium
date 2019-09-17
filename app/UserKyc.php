<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{
    protected $table = 'user_kyc';

    protected $fillable = ['user_id', 'kyc_type', 'response_payload'];

}
