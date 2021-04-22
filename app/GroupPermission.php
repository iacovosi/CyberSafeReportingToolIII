<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use League\Flysystem\Exception;

use App\User;

class GroupPermission extends Model
{
    //

    protected $fillable = ['role_id', 'group_id', 'view', 'edit', 'create', 'delete'];

    public static function usercan($permission, $group)
    {
        $user = User::find(Auth::id());
        return $user->hasPermissionTo($permission.'_'.$group);
    }

    public static function canuser($userid, $permission, $group)
    {
        $user = User::find($userid);
        return $user->hasPermissionTo($permission.'_'.$group);
    }

}


