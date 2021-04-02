<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Status;

class Helpline extends Model
{
    //
    protected $fillable = [
        // 'resourcetype','contenttype','age','comments','phone','name','surname','email','log','status','user_id','actions','reference','referal','gender','vector','is_it_hotline','submission_type','transfer_from', 'operator'];
        'is_it_hotline','submission_type',
        'name','surname','email','phone','age','gender','report_role',
        'resource_type','resource_url','content_type','comments',
        'user_opened','user_assigned','priority','reference_by','reference_to','actions','status',
        'log','insident_reference_id','call_time','manager_comments',
    ];

    public function hasStatus(){
        return $this->hasOne(Status::class,'id','status');
    }

    public function firstResponder()
    {
        return $this->hasOne('App\User','id','user_opened');
    }
    public function lastResponder()
    {
        return $this->hasOne('App\User','id','user_assigned');
    }

    public function scopeOfStatus($query, $status)
    {
        if ($status == "*") {
            return $query->where('status', '<>', "Closed");
        } else {
            return $query->whereStatus($status);
        }
    }

    // public function scopeOfUser($query, $userId)
    // {
    //     if ($status == "*") {
    //         return;
    //     } else {
    //         return $query->where('user_id',$userId);
    //     }
    // }

    public function relatedToStatistics(){
        return $this->hasOne('App\Statistics','tracking_id','id');
    }
}
