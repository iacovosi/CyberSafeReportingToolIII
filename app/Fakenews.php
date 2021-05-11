<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakenews extends Model
{
    //
    protected $fillable = ['source_url',
    'title',
    'source_document',
    'tv_channel',
    'tv_prog_title',
    'radio_station',
    'radio_freq',
    'newspaper_name',
    'page',
    'specific_type',
    'evaluation',
    'fakenews_source_type',
    'fakenews_type',
    'country',
    'town',
    'area_district',
    'specific_address',
    'submission_type',
    'img_upload',
    'comments',
    'publication_date',
    'publication_time',

    'name',
    'surname',
    'email',
    'phone',
    'age',
    'gender',
    'report_role',

    'user_opened',
    'user_assigned',
    'priority',
    'reference_by',
    'reference_to',
    'actions',
    'status',

    'log',
    'specialty',
    'manager_comments',
    'insident_reference_id',
    'call_time',
    
];
}

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
