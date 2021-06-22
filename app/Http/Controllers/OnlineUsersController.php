<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\User;
use Illuminate\Support\Arr;

use App\GroupPermission; 

class OnlineUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (GroupPermission::usercan('view','online_users')){
            $users = User::all();
            $online = [];

            foreach ($users as $user) {
                if (Redis::get('user:'.$user->id)) {
                    $online = Arr::prepend($online, $user);
                }
            }
            return $online;
        }
        return [];
    }
}
