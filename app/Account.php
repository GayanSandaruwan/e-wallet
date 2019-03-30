<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //

    protected $fillable = [
        'account_name', 'account_desc', 'state', 'user_id', 'balance'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function transactions(){

        return $this->hasMany('App\Transaction');
    }

    public function goals(){

        return $this->hasMany('App\Goal');
    }


}
