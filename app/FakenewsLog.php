<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakenewsLog extends Model
{
    public function __construct(array $attributes = array()){
        
        // Remove from array
        unset($attributes['id']);
        unset($attributes['log']);
        unset($attributes['first_responder']);
        unset($attributes['last_responder']);
        unset($attributes['deleted_at']);

        parent::__construct($attributes);

        // encrypt personal details
        $this->name = Crypt::encryptString($attributes['name']);
        $this->surname = Crypt::encryptString($attributes['surname']);
        $this->email = Crypt::encryptString($attributes['email']);
        $this->phone = Crypt::encryptString($attributes['phone']);

        // encrypt url
        if ($attributes['fakenews_source_type']=='Internet')
        {
            $this->resource_url = Crypt::encryptString($attributes['resource_url']);
        }
       
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
