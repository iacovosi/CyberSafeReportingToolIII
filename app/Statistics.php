<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
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

    public function relatedToHelpLine(){
        return $this->hasOne('App\Helpline','id','tracking_id');
    }

}
