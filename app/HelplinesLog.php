<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class HelplinesLog extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'forwarded' => false,
        'is_it_hotline' => false
    ];

    public function __construct(array $attributes = array()){
        
        if (count($attributes)<=0){
            parent::__construct($attributes);
            return;
        }

        // Remove from array
        unset($attributes['id']);
        unset($attributes['log']);
        unset($attributes['first_responder']);
        unset($attributes['last_responder']);
        unset($attributes['deleted_at']);

        // fix strings from helpline to save space
        isset($attributes['is_it_hotline']) && $attributes['is_it_hotline'] === 'true' ? $attributes['is_it_hotline']=true:$attributes['is_it_hotline']=false;
        isset($attributes['forwarded']) && $attributes['forwarded'] === 'true'?$attributes['forwarded']=true:$attributes['forwarded']=false;

        parent::__construct($attributes);

        // encrypt personal details
        $this->name = Crypt::encryptString($attributes['name']);
        $this->surname = Crypt::encryptString($attributes['surname']);
        $this->email = Crypt::encryptString($attributes['email']);
        $this->phone = Crypt::encryptString($attributes['phone']);

        // encrypt url
        $this->resource_url = Crypt::encryptString($attributes['resource_url']);
    }

    public function changedBy(){
        return $this->hasOne('App\User', 'id', 'changed_by');
    }

    public function firstOpened(){
        return $this->hasOne('App\User', 'id', 'user_opened');
    }

    public function assignedTo(){
        return $this->hasOne('App\User', 'id', 'user_assigned');
    }

}
