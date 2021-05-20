<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakenewsStatistics extends Model
{
    //
    public function scopeOfStatus($query, $status)
    {
        if ($status == "*") {
            return;
        } else {
            return $query->whereStatus($status);
        }
    }

    public function firstResponderStats()
    {
        return $this->hasOne('App\User','id','user_opened');
    }
    public function lastResponderStats()
    {
        return $this->hasOne('App\User','id','user_assigned');
    }
}
