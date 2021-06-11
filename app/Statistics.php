<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'submission_type' => 'electronic-form',
        'age' => 'Not Set',
        'gender' => 'Not Set',
        'report_role' => 'Not Set',
        'priority' => 'Not Set',
        'reference_by' => 'Not Set',
        'reference_to' => 'Not Set',
        'actions' => 'Not Set',
        'status' => 'New',
    ];

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
