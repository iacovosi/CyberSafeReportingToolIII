<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function Users()
    {
        return $this->belongsToMany('App\User');
    }
}
