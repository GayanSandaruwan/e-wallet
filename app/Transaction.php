<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'trans_desc', 'type', 'effective_date', 'account_id', 'user_id', 'amount',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
