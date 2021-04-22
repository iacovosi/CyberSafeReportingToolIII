<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function UserHasRoles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function firstResponder()
    {
        return $this->belongsTo('App\Helpline', 'id', 'user_opened');
    }

    public function lastResponder()
    {
        return $this->belongsTo('App\Helpline', 'id', 'user_assigned');
    }

    public function firstResponderStats()
    {
        return $this->belongsTo('App\Statistics', 'id', 'user_opened');
    }

    public function lastResponderStats()
    {
        return $this->belongsTo('App\Statistics', 'id', 'user_assigned');
    }

    public function getInsidentReference()
    {
        return $this->belongsTo('App\User', 'id', 'insident_reference_id');
    }

    //check if is a Helpline only user
    public function checkRole($roletoCheck)
    {
        $IsUserRole = 0;
        $role = Role::where('name', $roletoCheck)->get();
        if (!empty($role) && count($role) != 0) {
            $role_id = $role[0]->id;
            $user = auth()->user();
            $checkRoles = User::find($user->id)->UserHasRoles()->where('role_id', $role_id)->get();
            $IsUserRole = count($checkRoles) == 0 ? 0 : 1;//if helpline show only helpline . Elsewhere show all!
        }
        return $IsUserRole;
    }

    public static function loggedUsers($cursor = null, $allResults = array())
    {
        // Zero means full iteration
        if ($cursor === "0") {
            // Get rid of duplicated values caused by redis scan limitations.
            $allResults = array_unique($allResults);
            // Setting users array
            $users = array();
            // Looping through all results. Inserting each logged user into array.
            foreach ($allResults as $result) {
                $users[] = User::where('id', Redis::Get($result))->first();
            }
            // Removing duplicate items. (If user has logged in using more than one machine)
            $users = array_unique($users);
            return $users;
        }
        // No $cursor means init
        if ($cursor === null) {
            $cursor = "0";
        }
        // The call
        $result = Redis::scan($cursor, 'match', 'users:*');
        // Append results to array
        $allResults = array_merge($allResults, $result[1]);
        // Recursive call until cursor is 0
        return self::loggedUsers($result[0], $allResults);
    }

    public function isOnline()
    {
        $returnValue=false;
        $users =Self::loggedUsers();
        foreach ($users as $user) {
            if ($user->id==$this->id) {
                $returnValue=true;
            }
        }
        return $returnValue;
    }

}