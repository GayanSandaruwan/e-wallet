<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    //
    protected $fillable = [
        'goal_name', 'account_id', 'user_id', 'state','notified','target_value'
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
