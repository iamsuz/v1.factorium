<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoExchangeTransaction extends Model
{
    protected $table = 'crypto_exchange_transactions';

    protected $fillable = ['user_id', 'source_token', 'source_token_amount', 'dest_token', 'dest_token_amount', 'transaction_hash', 'transaction_response1', 'transaction_response2'];
}
