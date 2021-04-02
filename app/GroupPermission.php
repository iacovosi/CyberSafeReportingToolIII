<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Permission;
use League\Flysystem\Exception;

class GroupPermission extends Model
{
    //

    protected $fillable = ['user_id', 'permission_id', 'group_id'];

    public static function usercan($permission, $group)
    {
        //Get the permission object to use it on validation command after
        $permissionobject = Permission::where('name', $permission)->first();
        //Get Group object to use it on validation command after
        $groupobject = Group::where('name',$group)->first();

        /**
         * Try catch errors that might occur on the $validation
         * e.g. if one of the objects does not exist.
         *
         * Return false if errors exist ("Might Change on production")
         * and if thereis no object on validation.
         */
        try {
            $validaiton = GroupPermission::where('user_id', Auth::id())->where('group_id', $groupobject->id)->where('permission_id', $permissionobject->id)->get();
            if (count($validaiton) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            //Todo change on production not to dd and send error msg. or to return false
            //dd($ex->getMessage());
            return false;
        }

    }

        public static function canuser($userid,$permission, $group)
    {
        //Get the permission object to use it on validation command after
        $permissionobject = Permission::where('name', $permission)->first();
        //Get Group object to use it on validation command after
        $groupobject = Group::where('name',$group)->first();

        $user = User::find($userid);
        /**
         * Try catch errors that might occur on the $validation
         * e.g. if one of the objects does not exist.
         *
         * Return false if errors exist ("Might Change on production")
         * and if thereis no object on validation.
         */
        try {
            $validaiton = GroupPermission::where('user_id', $user->id)->where('group_id', $groupobject->id)->where('permission_id', $permissionobject->id)->get();
            if (count($validaiton) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            //Todo change on production not to dd and send error msg. or to return false
            dd($ex->getMessage());
            return false;
        }

    }



    public static function attachGroupPermission($user,$permission,$group){
        $gp = GroupPermission::create(['user_id' => $user,'permission_id' => $permission, 'group_id' => $group]);

    }

    public function GroupName(){
        return $this->hasOne(Group::class,'id','group_id');
    }
    public function PermissionName(){
        return $this->hasOne(Permission::class, 'id','permission_id');
    }

}


